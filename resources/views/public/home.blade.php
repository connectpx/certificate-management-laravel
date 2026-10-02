@extends('layouts.public')

@section('title', 'Verify Security Dog Handler Certificates')

@section('content')
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>

    <div class="site-container hero-content">
        <p class="font-display hero-brand hero-fade">BASDU</p>
        <h1 class="font-display hero-title hero-rise">
            Verify Security Dog Handler Certificates
        </h1>
        <p class="hero-copy hero-rise hero-rise-delay-1">
            Search by certificate number or handler name.
        </p>

        <form action="{{ route('search') }}" method="GET" class="hero-form hero-rise hero-rise-delay-2">
            <div class="hero-form-row">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    required
                    placeholder="BASDU/OA/2025/0147 or handler name"
                    class="field field-borderless"
                >
                <button type="submit" class="btn-primary btn-accent">Search</button>
            </div>
        </form>
    </div>
</section>

<section class="site-container section">
    <div class="section-head">
        <div>
            <h2 class="font-display section-title">Recent certificates</h2>
            <p class="section-copy">Latest active records in the registry.</p>
        </div>
        <a href="{{ route('certificates.index') }}" class="site-link">View all</a>
    </div>

    <div class="border-t">
        @forelse(\App\Models\Certificate::query()->active()->latest('date_of_assessment')->limit(6)->get() as $certificate)
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="cert-row">
                <div class="cert-row-inner">
                    <div>
                        <div class="font-display text-xl" style="color: var(--brand);">{{ $certificate->handler_name }}</div>
                        <div class="mt-1 text-sm muted">{{ $certificate->certificate_number }} · {{ $certificate->training_organization }}</div>
                    </div>
                    <div class="cert-row-meta">
                        <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
                        <span class="muted">{{ $certificate->date_of_assessment->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="empty">No active certificates yet.</p>
        @endforelse
    </div>
</section>
@endsection
