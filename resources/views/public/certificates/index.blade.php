@extends('layouts.public')

@section('title', 'Certificates')

@section('content')
<section class="panel">
    <div class="site-container panel-inner">
        <h1 class="font-display page-title">Certificates</h1>
        <p class="mt-2 muted">Browse active operational assessment records.</p>

        <form method="GET" class="search-row">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by number or name" class="field">
            <button class="btn-primary">Search</button>
        </form>
    </div>
</section>

<section class="site-container section-sm">
    <div class="border-t">
        @forelse($certificates as $certificate)
            <a href="{{ route('certificates.show', $certificate->slug) }}" class="cert-row">
                <div class="cert-row-inner">
                    <div>
                        <div class="font-display text-xl" style="color: var(--brand);">{{ $certificate->handler_name }}</div>
                        <div class="mt-1 text-sm muted">
                            {{ $certificate->certificate_number }} · {{ $certificate->training_organization }}
                        </div>
                    </div>
                    <div class="cert-row-meta">
                        <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
                        <span class="muted">{{ $certificate->date_of_assessment->format('d M Y') }}</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="empty-center">No certificates found.</p>
        @endforelse
    </div>

    <div class="mt-8">{{ $certificates->links('vendor.pagination.simple') }}</div>
</section>
@endsection
