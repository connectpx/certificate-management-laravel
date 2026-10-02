@extends('layouts.public')

@section('title', 'Verify Security Dog Handler Certificates')

@section('content')
<section class="relative overflow-hidden border-b border-[var(--line)] bg-[var(--brand)] text-white">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(154,123,47,0.22),_transparent_50%),linear-gradient(160deg,#0b2a43_0%,#0f3554_55%,#0b2a43_100%)]"></div>
    <div class="absolute inset-0 opacity-[0.07]" style="background-image:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="site-container relative py-20 md:py-28">
        <p class="hero-fade font-display text-5xl tracking-tight text-white md:text-7xl">BASDU</p>
        <h1 class="hero-rise mt-5 max-w-2xl font-display text-3xl leading-tight text-white/95 md:text-4xl">
            Verify Security Dog Handler Certificates
        </h1>
        <p class="hero-rise mt-4 max-w-xl text-base text-white/70 md:text-lg" style="animation-delay:80ms">
            Search by certificate number or handler name.
        </p>

        <form action="{{ route('search') }}" method="GET" class="hero-rise mt-10 max-w-xl" style="animation-delay:140ms">
            <div class="flex flex-col gap-3 sm:flex-row">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    required
                    placeholder="BASDU/OA/2025/0147 or handler name"
                    class="field border-0"
                >
                <button type="submit" class="btn-primary bg-[var(--accent)] hover:bg-[#866b28] sm:shrink-0">
                    Search
                </button>
            </div>
        </form>
    </div>
</section>

<section class="site-container py-16">
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl text-[var(--brand)] md:text-3xl">Recent certificates</h2>
            <p class="mt-1 text-sm text-[var(--muted)]">Latest active records in the registry.</p>
        </div>
        <a href="{{ route('certificates.index') }}" class="site-link shrink-0">View all</a>
    </div>

    <div class="border-t border-[var(--line)]">
        @forelse(\App\Models\Certificate::query()->active()->latest('date_of_assessment')->limit(6)->get() as $certificate)
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="cert-row">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="font-display text-xl text-[var(--brand)]">{{ $certificate->handler_name }}</div>
                        <div class="mt-1 text-sm text-[var(--muted)]">{{ $certificate->certificate_number }} · {{ $certificate->training_organization }}</div>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
                        <span class="text-[var(--muted)]">{{ $certificate->date_of_assessment->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="py-10 text-[var(--muted)]">No active certificates yet.</p>
        @endforelse
    </div>
</section>
@endsection
