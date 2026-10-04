<?php

namespace App\Services\Career;

use App\Models\CareerApplication;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CareerCvService
{
    /**
     * Store the uploaded CV in a secure private directory.
     *
     * @param UploadedFile $file
     * @param int $jobId
     * @return array
     */
    public function storeCv(UploadedFile $file, int $jobId): array
    {
        $year = date('Y');
        $month = date('m');
        $targetDirectory = storage_path("app/private/careers/{$jobId}/{$year}/{$month}");

        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'pdf');
        $randomHash = Str::random(24);
        $filename = "app-cv-{$jobId}-{$year}{$month}-{$randomHash}.{$extension}";

        $file->move($targetDirectory, $filename);

        $relativePath = "careers/{$jobId}/{$year}/{$month}/{$filename}";
        $fullPath = $targetDirectory . DIRECTORY_SEPARATOR . $filename;
        $mimeType = File::mimeType($fullPath) ?: $file->getClientMimeType() ?: 'application/octet-stream';
        $size = File::size($fullPath);

        return [
            'original_name' => $originalName,
            'storage_path' => $relativePath,
            'mime_type' => $mimeType,
            'size' => $size,
        ];
    }

    /**
     * Get absolute path on server.
     */
    public function getAbsolutePath(string $storagePath): string
    {
        // Check if already absolute
        if (File::exists($storagePath)) {
            return $storagePath;
        }

        $privatePath = storage_path('app/private/' . ltrim($storagePath, '/\\'));
        if (File::exists($privatePath)) {
            return $privatePath;
        }

        $appPath = storage_path('app/' . ltrim($storagePath, '/\\'));
        if (File::exists($appPath)) {
            return $appPath;
        }

        return $privatePath;
    }

    /**
     * Check if the CV file exists.
     */
    public function fileExists(CareerApplication $application): bool
    {
        if (empty($application->cv_storage_path)) {
            return false;
        }
        $fullPath = $this->getAbsolutePath($application->cv_storage_path);
        return File::exists($fullPath);
    }

    /**
     * Stream or download the CV file.
     */
    public function getResponse(CareerApplication $application, bool $download = false): BinaryFileResponse
    {
        $fullPath = $this->getAbsolutePath($application->cv_storage_path);

        if (!File::exists($fullPath)) {
            abort(404, 'The requested CV file could not be found on the server.');
        }

        $mimeType = $application->cv_mime_type ?: (File::mimeType($fullPath) ?: 'application/octet-stream');
        $downloadName = $application->cv_original_name ?: basename($fullPath);

        $headers = [
            'Content-Type' => $mimeType,
            'Content-Length' => File::size($fullPath),
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        if ($download) {
            return response()->download($fullPath, $downloadName, $headers);
        }

        $disposition = in_array(strtolower(pathinfo($downloadName, PATHINFO_EXTENSION)), ['pdf', 'png', 'jpg', 'jpeg', 'webp', 'gif'])
            ? 'inline; filename="' . addslashes($downloadName) . '"'
            : 'attachment; filename="' . addslashes($downloadName) . '"';

        $headers['Content-Disposition'] = $disposition;

        return response()->file($fullPath, $headers);
    }

    /**
     * Delete the CV file from disk.
     */
    public function deleteCv(CareerApplication $application): bool
    {
        if (empty($application->cv_storage_path)) {
            return false;
        }
        $fullPath = $this->getAbsolutePath($application->cv_storage_path);
        if (File::exists($fullPath)) {
            return File::delete($fullPath);
        }
        return false;
    }
}
