<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateExportService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function index(Request $request): View
    {
        $certificates = Certificate::query()
            ->active()
            ->search($request->string('q')->toString())
            ->latest('date_of_assessment')
            ->paginate(9)
            ->withQueryString();

        return view('public.certificates.index', compact('certificates'));
    }

    public function show(string $slug): View
    {
        $certificate = Certificate::findBySlug($slug);

        abort_if(! $certificate || ! $certificate->isActive(), 404);

        $certificate->load(['approvedComments' => fn ($query) => $query->latest()]);

        return view('public.certificates.show', compact('certificate'));
    }

    public function pdf(string $slug, CertificateExportService $exportService): Response
    {
        $certificate = Certificate::findBySlug($slug);

        abort_if(! $certificate || ! $certificate->isActive(), 404);

        return $exportService->pdf($certificate);
    }

    public function image(string $slug, CertificateExportService $exportService): StreamedResponse
    {
        $certificate = Certificate::findBySlug($slug);

        abort_if(! $certificate || ! $certificate->isActive(), 404);

        return $exportService->image($certificate);
    }
}
