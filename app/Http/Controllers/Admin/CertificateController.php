<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCertificateRequest;
use App\Http\Requests\Admin\UpdateCertificateRequest;
use App\Models\Certificate;
use App\Services\CertificateExportService;
use App\Services\CertificateNumberGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function index(Request $request): View
    {
        $certificates = Certificate::query()
            ->search($request->string('q')->toString())
            ->latest('date_of_assessment')
            ->paginate(10)
            ->withQueryString();

        return view('admin.certificates.index', compact('certificates'));
    }

    public function create(CertificateNumberGenerator $generator): View
    {
        return view('admin.certificates.create', [
            'suggestedNumber' => $generator->generate(),
        ]);
    }

    public function store(StoreCertificateRequest $request, CertificateNumberGenerator $generator): RedirectResponse
    {
        $data = $request->validated();
        $data['certificate_number'] = filled($data['certificate_number'] ?? null)
            ? $data['certificate_number']
            : $generator->generate();

        $certificate = Certificate::query()->create($data);

        return redirect()
            ->route('admin.certificates.show', $certificate)
            ->with('success', 'Certificate created successfully.');
    }

    public function show(Certificate $certificate): View
    {
        $certificate->load(['comments' => fn ($query) => $query->latest()]);

        return view('admin.certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(UpdateCertificateRequest $request, Certificate $certificate): RedirectResponse
    {
        $certificate->update($request->validated());

        return redirect()
            ->route('admin.certificates.show', $certificate)
            ->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()
            ->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully.');
    }

    public function toggleStatus(Certificate $certificate): RedirectResponse
    {
        $certificate->update([
            'status' => $certificate->isActive()
                ? Certificate::STATUS_INACTIVE
                : Certificate::STATUS_ACTIVE,
        ]);

        return back()->with('success', 'Certificate status updated.');
    }

    public function pdf(Certificate $certificate, CertificateExportService $exportService): Response
    {
        return $exportService->pdf($certificate);
    }

    public function image(Certificate $certificate, CertificateExportService $exportService): StreamedResponse
    {
        return $exportService->image($certificate);
    }
}
