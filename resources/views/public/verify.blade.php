@extends('layouts.public')

@section('title', 'Certificate Verification')

@section('content')
<section class="site-container section-sm">
    <h1 class="font-display page-title">Verification</h1>
    <p class="mt-2 text-sm muted">Reference: <span class="font-mono" style="color: var(--ink);">{{ $slug }}</span></p>

    @if ($status === 'not_found')
        <div class="notice notice-danger mt-10">
            <p class="notice-title">Certificate not found</p>
            <p class="mt-1 text-sm muted">Check the number and try again from the home page.</p>
            <a href="{{ route('home') }}" class="btn-primary mt-4">Back to search</a>
        </div>
    @elseif ($status === 'invalid')
        <div class="notice notice-warn mt-10">
            <p class="notice-title">Inactive certificate</p>
            <p class="mt-1 text-sm muted">This record exists but is not currently valid.</p>
        </div>
        <div class="preview-box overflow-x opacity-70 mt-8">
            @include('certificates.partials.design', ['certificate' => $certificate])
        </div>
    @else
        <div class="notice notice-success mt-10">
            <p class="notice-title">Valid certificate</p>
            <p class="mt-1 text-sm muted">Active and verified in the official registry.</p>
        </div>

        <div class="actions mt-6">
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="btn-primary">View details</a>
            <a href="{{ route('certificates.pdf', $certificate->slug) }}" class="btn-secondary">PDF</a>
            <a href="{{ route('certificates.image', $certificate->slug) }}" class="btn-secondary">Image</a>
        </div>

        <div class="preview-box overflow-x mt-8">
            @include('certificates.partials.design', ['certificate' => $certificate])
        </div>

        <div class="mt-10">
            <h2 class="font-display section-title">Details</h2>
            <dl class="mt-5 grid-2" style="gap:1rem;">
                <div class="border-b pb-3"><span class="muted text-sm">Handler</span><div class="mt-1">{{ $certificate->handler_name }}</div></div>
                <div class="border-b pb-3"><span class="muted text-sm">Certificate No</span><div class="mt-1">{{ $certificate->certificate_number }}</div></div>
                <div class="border-b pb-3"><span class="muted text-sm">Organization</span><div class="mt-1">{{ $certificate->training_organization }}</div></div>
                <div class="border-b pb-3"><span class="muted text-sm">Assessor</span><div class="mt-1">{{ $certificate->assessor_name }}</div></div>
                <div class="border-b pb-3"><span class="muted text-sm">Date</span><div class="mt-1">{{ $certificate->date_of_assessment->format('d F Y') }}</div></div>
                <div class="border-b pb-3"><span class="muted text-sm">Result</span><div class="mt-1 font-semibold">{{ $certificate->result }}</div></div>
            </dl>
        </div>
    @endif
</section>
@endsection
