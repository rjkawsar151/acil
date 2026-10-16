<?php

namespace App\Services\Career;

use App\Models\CareerApplication;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class CareerExportService
{
    protected CareerCvService $cvService;

    public function __construct(CareerCvService $cvService)
    {
        $this->cvService = $cvService;
    }

    /**
     * Resolve applicant collection based on request filters or explicit IDs.
     */
    public function resolveApplications(Request $request, ?string $forcedStatus = null): Collection
    {
        $query = CareerApplication::with(['job.department', 'answers']);

        // 1. If explicit IDs provided (e.g. bulk checkboxes)
        if ($request->filled('ids') && is_array($request->input('ids'))) {
            $ids = array_filter(array_map('intval', $request->input('ids')));
            if (!empty($ids)) {
                return $query->whereIn('id', $ids)->latest('applied_at')->get();
            }
        }

        // 2. Status filtering (forcedStatus has precedence, then request status)
        $status = $forcedStatus ?: $request->input('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // 3. Job position filter
        $jobId = $request->input('job_id');
        if ($jobId && $jobId !== 'all') {
            $query->where('career_job_id', $jobId);
        }

        // 4. Search query filter
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%");
            });
        }

        // 5. Date filter
        $dateFilter = $request->input('date_filter');
        if ($dateFilter) {
            match ($dateFilter) {
                'today' => $query->whereDate('applied_at', now()->toDateString()),
                'this_week' => $query->whereBetween('applied_at', [now()->startOfWeek(), now()->endOfWeek()]),
                'this_month' => $query->whereBetween('applied_at', [now()->startOfMonth(), now()->endOfMonth()]),
                default => null,
            };
        }

        return $query->latest('applied_at')->get();
    }

    /**
     * Generate a ZIP archive containing candidate CV files and an index summary.
     *
     * @param Collection $applications
     * @param string $scopeLabel
     * @return array [ 'zip_path' => string, 'filename' => string, 'count' => int ]
     * @throws \RuntimeException
     */
    public function buildCvZip(Collection $applications, string $scopeLabel = 'All'): array
    {
        if ($applications->isEmpty()) {
            throw new \RuntimeException('No candidate applications were found for the selected export criteria.');
        }

        $tempDir = storage_path('app/temp/exports');
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }

        $timestamp = date('Ymd_His');
        $cleanScope = Str::slug($scopeLabel, '_');
        $zipFilename = "ACIL_CVs_{$cleanScope}_{$timestamp}.zip";
        $zipFilePath = $tempDir . DIRECTORY_SEPARATOR . $zipFilename;

        $zip = new ZipArchive();
        $openResult = $zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($openResult !== true) {
            throw new \RuntimeException("Unable to initialize ZIP archive (code: {$openResult}).");
        }

        $addedCount = 0;
        $indexRows = [];
        $usedEntryNames = [];

        foreach ($applications as $index => $app) {
            $hasCv = $this->cvService->fileExists($app);
            $entryName = 'N/A (Missing)';

            if ($hasCv) {
                $realPath = $this->cvService->getAbsolutePath($app->cv_storage_path);
                $ext = pathinfo($app->cv_original_name ?: $realPath, PATHINFO_EXTENSION) ?: 'pdf';
                
                // Clean formatted filename inside ZIP: Ref_CandidateName_Position.ext
                $candidateName = Str::slug($app->name, '_');
                $jobTitle = Str::slug($app->job->title ?? 'Position', '_');
                $baseEntryName = "{$app->reference}_{$candidateName}_{$jobTitle}.{$ext}";
                
                // Avoid potential name collisions in zip
                $finalEntryName = $baseEntryName;
                $counter = 1;
                while (isset($usedEntryNames[$finalEntryName])) {
                    $finalEntryName = "{$app->reference}_{$candidateName}_{$jobTitle}_{$counter}.{$ext}";
                    $counter++;
                }
                $usedEntryNames[$finalEntryName] = true;

                if ($zip->addFile($realPath, $finalEntryName)) {
                    $addedCount++;
                    $entryName = $finalEntryName;
                }
            }

            $indexRows[] = [
                'sl' => $index + 1,
                'ref' => $app->reference,
                'name' => $app->name,
                'position' => $app->job->title ?? 'N/A',
                'status' => $app->status_label,
                'email' => $app->email,
                'phone' => $app->phone,
                'applied' => $app->applied_at ? $app->applied_at->format('Y-m-d H:i') : '—',
                'file' => $entryName,
            ];
        }

        // Generate ASCII text index file inside the ZIP archive
        $companyName = Setting::get('site_name', 'Adonis Chemical Industries Ltd.');
        $generatedAt = now()->format('d M Y, h:i A');
        $totalApps = $applications->count();

        $indexText = "========================================================================================\r\n";
        $indexText .= "{$companyName}\r\n";
        $indexText .= "Human Resources Recruitment Desk — Candidate CV Package\r\n";
        $indexText .= "========================================================================================\r\n";
        $indexText .= "Scope / Filter : {$scopeLabel}\r\n";
        $indexText .= "Generated At   : {$generatedAt}\r\n";
        $indexText .= "Total Records  : {$totalApps} Applicants\r\n";
        $indexText .= "CV Files Packed: {$addedCount} Documents\r\n";
        $indexText .= "========================================================================================\r\n\r\n";
        $indexText .= sprintf("%-4s | %-16s | %-22s | %-24s | %-16s | %-32s\r\n", "SL", "Reference", "Candidate Name", "Position Applied", "Status", "CV Filename in Archive");
        $indexText .= str_repeat("-", 125) . "\r\n";

        foreach ($indexRows as $row) {
            $indexText .= sprintf(
                "%-4s | %-16s | %-22s | %-24s | %-16s | %-32s\r\n",
                $row['sl'],
                $row['ref'],
                mb_strimwidth($row['name'], 0, 22, '..'),
                mb_strimwidth($row['position'], 0, 24, '..'),
                $row['status'],
                $row['file']
            );
        }

        $indexText .= "\r\n========================================================================================\r\n";
        $indexText .= "CONFIDENTIAL HR ASSET — FOR INTERNAL RECRUITMENT COMMITTEE EVALUATION ONLY\r\n";

        $zip->addFromString('00_README_Candidate_Index.txt', $indexText);
        $zip->close();

        return [
            'zip_path' => $zipFilePath,
            'filename' => $zipFilename,
            'count' => $addedCount,
            'total' => $totalApps,
        ];
    }

    /**
     * Generate formatted A4-friendly XLS spreadsheet HTML.
     *
     * @param Collection $applications
     * @param string $scopeLabel
     * @return string Raw HTML content for .xls file
     */
    public function generateA4XlsHtml(Collection $applications, string $scopeLabel = 'All Applicants'): string
    {
        $companyName = Setting::get('site_name', 'Adonis Chemical Industries Ltd.');
        $generatedAt = now()->format('d M Y, h:i A');
        $generatedBy = auth()->user()?->name ?? 'HR Recruitment Desk';
        $totalCount = $applications->count();

        // Tally by status
        $statusCounts = [];
        foreach ($applications as $app) {
            $statusCounts[$app->status_label] = ($statusCounts[$app->status_label] ?? 0) + 1;
        }
        $breakdownStr = [];
        foreach ($statusCounts as $lbl => $cnt) {
            $breakdownStr[] = "{$lbl}: {$cnt}";
        }
        $breakdownText = implode('  |  ', $breakdownStr);

        ob_start();
        ?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--[if gte mso 9]>
<xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Applicant Registry</x:Name>
    <x:WorksheetOptions>
     <x:Print>
      <x:ValidPrinterInfo/>
      <x:PaperSizeIndex>9</x:PaperSizeIndex> <!-- 9 = Standard A4 -->
      <x:Orientation>Landscape</x:Orientation>
      <x:FitWidth>1</x:FitWidth>
      <x:FitHeight>0</x:FitHeight>
      <x:Scale>80</x:Scale>
     </x:Print>
     <x:Selected/>
     <x:DoNotDisplayGridlines/>
     <x:TopRowVisible>0</x:TopRowVisible>
     <x:LeftColumnVisible>0</x:LeftColumnVisible>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
 </x:ExcelWorkbook>
</xml>
<![endif]-->
<style>
@page {
    size: A4 landscape;
    margin: 0.45in 0.35in 0.45in 0.35in;
    mso-page-orientation: landscape;
    mso-header-margin: 0.25in;
    mso-footer-margin: 0.25in;
}

body {
    font-family: 'Segoe UI', Calibri, Arial, sans-serif;
    color: #1e293b;
    margin: 0;
    padding: 0;
    background-color: #ffffff;
}

table {
    border-collapse: collapse;
    width: 100%;
    table-layout: auto;
}

.table-header-banner {
    background: #071B33;
    color: #ffffff;
}

.banner-company {
    font-size: 16pt;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.5px;
    padding: 12px 14px 2px 14px;
}

.banner-sub {
    font-size: 9pt;
    color: #93c5fd;
    padding: 0 14px 10px 14px;
}

.meta-box {
    background: #f8fafc;
    border-bottom: 1.5pt solid #0284c7;
    font-size: 8.5pt;
    color: #475569;
    padding: 6px 14px;
}

.col-header th {
    background-color: #0b2545;
    color: #ffffff;
    font-size: 8.5pt;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    padding: 9px 6px;
    border: 0.5pt solid #1e3a5f;
    text-align: left;
    white-space: nowrap;
}

.col-header th.text-center {
    text-align: center;
}

.data-row td {
    font-size: 8.5pt;
    padding: 6px 6px;
    border: 0.5pt solid #cbd5e1;
    vertical-align: middle;
    color: #1e293b;
}

.data-row-alt td {
    background-color: #f8fafc;
    font-size: 8.5pt;
    padding: 6px 6px;
    border: 0.5pt solid #cbd5e1;
    vertical-align: middle;
    color: #1e293b;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.font-bold { font-weight: bold; }
.text-mono {
    font-family: 'Consolas', monospace;
    mso-number-format: "\@";
}
.text-phone {
    mso-number-format: "\@";
    white-space: nowrap;
}
.text-wrap {
    word-break: break-word;
    white-space: normal;
}

/* Status cell pills */
.status-pending { background-color: #fef3c7; color: #92400e; font-weight: bold; }
.status-under_review { background-color: #e0f2fe; color: #0369a1; font-weight: bold; }
.status-shortlisted { background-color: #e0e7ff; color: #3730a3; font-weight: bold; }
.status-interview_scheduled { background-color: #f3e8ff; color: #6b21a8; font-weight: bold; }
.status-interviewed { background-color: #cffafe; color: #0e7490; font-weight: bold; }
.status-selected { background-color: #d1fae5; color: #065f46; font-weight: bold; }
.status-hired { background-color: #bbf7d0; color: #14532d; font-weight: bold; }
.status-rejected { background-color: #ffe4e6; color: #9f1239; font-weight: bold; }
.status-withdrawn { background-color: #f1f5f9; color: #64748b; font-weight: bold; }

.footer-cell {
    background-color: #071b33;
    color: #cbd5e1;
    font-size: 7.5pt;
    padding: 8px 14px;
    text-align: center;
}
</style>
</head>
<body>

<table>
    <!-- 1. Corporate Banner Header -->
    <tr class="table-header-banner">
        <td colspan="11" class="banner-company">
            <?= htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8') ?>
        </td>
    </tr>
    <tr class="table-header-banner">
        <td colspan="11" class="banner-sub">
            Candidate Recruitment & Applicant Screening Registry &bull; Savar Plant &bull; Reference & Screening Audit Sheet
        </td>
    </tr>

    <!-- 2. Export Metadata & Filter Context -->
    <tr class="meta-box">
        <td colspan="6" style="padding: 7px 10px; font-size: 8.5pt;">
            <strong>Scope / Filter:</strong> <?= htmlspecialchars($scopeLabel, ENT_QUOTES, 'UTF-8') ?> &nbsp;|&nbsp;
            <strong>Total Candidates:</strong> <?= $totalCount ?> &nbsp;|&nbsp;
            <strong>Exported By:</strong> <?= htmlspecialchars($generatedBy, ENT_QUOTES, 'UTF-8') ?>
        </td>
        <td colspan="5" style="padding: 7px 10px; font-size: 8.5pt; text-align: right;">
            <strong>Generated Date:</strong> <?= $generatedAt ?>
        </td>
    </tr>
    <?php if (!empty($breakdownText)): ?>
    <tr style="background: #e2e8f0; font-size: 8pt; color: #334155;">
        <td colspan="11" style="padding: 4px 10px;">
            <strong>Pipeline Status Breakdown:</strong> <?= htmlspecialchars($breakdownText, ENT_QUOTES, 'UTF-8') ?>
        </td>
    </tr>
    <?php endif; ?>

    <!-- 3. Table Column Headers (Optimized for A4 landscape fit) -->
    <tr class="col-header">
        <th class="text-center" style="width: 35px;">#</th>
        <th class="text-center" style="width: 110px;">Ref ID</th>
        <th style="width: 140px;">Candidate Name</th>
        <th style="width: 150px;">Position Applied</th>
        <th style="width: 100px;">Department</th>
        <th style="width: 140px;">Email Address</th>
        <th class="text-center" style="width: 100px;">Phone</th>
        <th class="text-center" style="width: 90px;">Applied Date</th>
        <th class="text-center" style="width: 115px;">Status</th>
        <th style="width: 130px;">CV Document</th>
        <th style="width: 220px;">Screening Answers / Questionnaire</th>
    </tr>

    <!-- 4. Data Rows -->
    <?php if ($applications->isEmpty()): ?>
        <tr class="data-row">
            <td colspan="11" class="text-center" style="padding: 30px; color: #64748b; font-size: 10pt;">
                No candidate applications match the selected criteria.
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($applications as $idx => $app): 
            $rowClass = ($idx % 2 === 0) ? 'data-row' : 'data-row-alt';
            $statusClass = 'status-' . ($app->status ?: 'pending');
            $hasCv = $this->cvService->fileExists($app);
            $cvDisplay = $hasCv 
                ? ($app->cv_original_name ?: 'Uploaded') . ' (' . $app->formatted_cv_size . ')'
                : 'Not uploaded / Missing';

            // Format screening questionnaire answers
            $qaSummary = [];
            if ($app->answers && $app->answers->count() > 0) {
                foreach ($app->answers as $ans) {
                    $qSnap = $ans->question_snapshot;
                    $ansText = $ans->formatted_answer;
                    $qaSummary[] = "• {$qSnap}: {$ansText}";
                }
            }
            $qaFormatted = !empty($qaSummary) ? implode("\n", $qaSummary) : '—';
        ?>
        <tr class="<?= $rowClass ?>">
            <td class="text-center font-bold"><?= $idx + 1 ?></td>
            <td class="text-center text-mono font-bold"><?= htmlspecialchars($app->reference, ENT_QUOTES, 'UTF-8') ?></td>
            <td class="font-bold"><?= htmlspecialchars($app->name, ENT_QUOTES, 'UTF-8') ?></td>
            <td style="color: #0369a1; font-weight: 600;"><?= htmlspecialchars($app->job->title ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($app->job->effective_department_name ?? 'General', ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($app->email, ENT_QUOTES, 'UTF-8') ?></td>
            <td class="text-center text-phone"><?= htmlspecialchars($app->phone, ENT_QUOTES, 'UTF-8') ?></td>
            <td class="text-center"><?= $app->applied_at ? $app->applied_at->format('d-M-Y') : '—' ?></td>
            <td class="text-center <?= $statusClass ?>">
                <?= htmlspecialchars($app->status_label, ENT_QUOTES, 'UTF-8') ?>
            </td>
            <td style="font-size: 7.5pt;">
                <?= htmlspecialchars($cvDisplay, ENT_QUOTES, 'UTF-8') ?>
            </td>
            <td class="text-wrap" style="font-size: 7.5pt; color: #334155; white-space: pre-line;">
                <?= htmlspecialchars($qaFormatted, ENT_QUOTES, 'UTF-8') ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- 5. Corporate Footer Note -->
    <tr>
        <td colspan="11" class="footer-cell">
            CONFIDENTIAL CANDIDATE EVALUATION RECORD &bull; ADONIS CHEMICAL INDUSTRIES LTD. &bull; SAVAR PLANT &bull; GENERATED VIA ACIL RECRUITMENT PORTAL
        </td>
    </tr>
</table>

</body>
</html>
        <?php
        return ob_get_clean();
    }
}
