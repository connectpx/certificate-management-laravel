@extends('layouts.public')

@section('title', 'Certificates')

@section('content')
<section class="border-b border-[var(--line)] bg-white">
    <div class="site-container py-12">
        <h1 class="font-display text-3xl text-[var(--brand)] md:text-4xl">Certificates</h1>
        <p class="mt-2 text-[var(--muted)]">Browse active operational assessment records.</p>

        <form method="GET" class="mt-8 flex max-w-lg flex-col gap-3 sm:flex-row">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by number or name" class="field">
            <button class="btn-primary sm:shrink-0">Search</button>
        </form>
    </div>
</section>

<section class="site-container py-10">
    <div class="border-t border-[var(--line)]">
        @forelse($certificates as $certificate)
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="cert-row">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="font-display text-xl text-[var(--brand)]">{{ $certificate->handler_name }}</div>
                        <div class="mt-1 text-sm text-[var(--muted)]">
                            {{ $certificate->certificate_number }} · {{ $certificate->training_organization }}
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
                        <span class="text-[var(--muted)]">{{ $certificate->date_of_assessment->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="py-12 text-center text-[var(--muted)]">No certificates found.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $certificates->links() }}</div>
</section>
@endsection
