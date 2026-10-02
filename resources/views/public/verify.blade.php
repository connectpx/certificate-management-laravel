@extends('layouts.public')

@section('title', 'Certificate Verification')

@section('content')
<section class="site-container py-12">
    <h1 class="font-display text-3xl text-[var(--brand)] md:text-4xl">Verification</h1>
    <p class="mt-2 text-sm text-[var(--muted)]">Reference: <span class="font-mono text-[var(--ink)]">{{ $slug }}</span></p>

    @if ($status === 'not_found')
        <div class="mt-10 border-l-4 border-rose-500 bg-white px-5 py-4">
            <p class="font-medium text-rose-800">Certificate not found</p>
            <p class="mt-1 text-sm text-[var(--muted)]">Check the number and try again from the home page.</p>
            <a href="{{ route('home') }}" class="btn-primary mt-4">Back to search</a>
        </div>
    @elseif ($status === 'invalid')
        <div class="mt-10 border-l-4 border-amber-500 bg-white px-5 py-4">
            <p class="font-medium text-amber-900">Inactive certificate</p>
            <p class="mt-1 text-sm text-[var(--muted)]">This record exists but is not currently valid.</p>
        </div>
        <div class="mt-8 overflow-x-auto bg-white p-3 opacity-70 md:p-6">
            @include('certificates.partials.design', ['certificate' => $certificate])
        </div>
    @else
        <div class="mt-10 border-l-4 border-emerald-600 bg-white px-5 py-4">
            <p class="font-medium text-emerald-800">Valid certificate</p>
            <p class="mt-1 text-sm text-[var(--muted)]">Active and verified in the official registry.</p>
        </div>

        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="btn-primary">View details</a>
            <a href="{{ route('certificates.pdf', $certificate->slug) }}" class="btn-secondary">PDF</a>
            <a href="{{ route('certificates.image', $certificate->slug) }}" class="btn-secondary">Image</a>
        </div>

        <div class="mt-8 overflow-x-auto bg-white p-3 md:p-6">
            @include('certificates.partials.design', ['certificate' => $certificate])
        </div>

        <div class="mt-10">
            <h2 class="font-display text-2xl text-[var(--brand)]">Details</h2>
            <dl class="mt-5 grid gap-4 text-sm md:grid-cols-2">
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Handler</span><div class="mt-1">{{ $certificate->handler_name }}</div></div>
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Certificate No</span><div class="mt-1">{{ $certificate->certificate_number }}</div></div>
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Organization</span><div class="mt-1">{{ $certificate->training_organization }}</div></div>
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Assessor</span><div class="mt-1">{{ $certificate->assessor_name }}</div></div>
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Date</span><div class="mt-1">{{ $certificate->date_of_assessment->format('d F Y') }}</div></div>
                <div class="border-b border-[var(--line)] pb-3"><span class="text-[var(--muted)]">Result</span><div class="mt-1 font-semibold">{{ $certificate->result }}</div></div>
            </dl>
        </div>
    @endif
</section>
@endsection
