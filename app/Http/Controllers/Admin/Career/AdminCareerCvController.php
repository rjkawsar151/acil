<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use App\Services\Career\CareerCvService;
use Illuminate\Http\Request;

class AdminCareerCvController extends Controller
{
    /**
     * Preview candidate CV in browser modal / tab.
     */
    public function preview(CareerApplication $application, CareerCvService $cvService)
    {
        if (!$cvService->fileExists($application)) {
            abort(404, 'The requested CV file is not found on the server storage.');
        }

        return $cvService->getResponse($application, false);
    }

    /**
     * Download candidate CV with original filename.
     */
    public function download(CareerApplication $application, CareerCvService $cvService)
    {
        if (!$cvService->fileExists($application)) {
            abort(404, 'The requested CV file is not found on the server storage.');
        }

        return $cvService->getResponse($application, true);
    }
}
