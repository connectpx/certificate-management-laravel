@extends('layouts.public')

@section('title', $certificate->handler_name.' — Certificate')

@section('content')
<section class="site-container py-12">
    <div class="mb-8 flex flex-col gap-5 border-b border-[var(--line)] pb-8 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm text-[var(--muted)]">{{ $certificate->certificate_number }}</p>
            <h1 class="mt-1 font-display text-3xl text-[var(--brand)] md:text-4xl">{{ $certificate->handler_name }}</h1>
            <p class="mt-2 text-sm text-[var(--muted)]">
                {{ $certificate->training_organization }} ·
                <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('certificates.pdf', $certificate->slug) }}" class="btn-primary">Download PDF</a>
            <a href="{{ route('certificates.image', $certificate->slug) }}" class="btn-secondary">Download Image</a>
            <a href="{{ route('verify.show', $certificate->slug) }}" class="btn-secondary">Verify</a>
        </div>
    </div>

    <div class="overflow-x-auto bg-white p-3 md:p-6">
        @include('certificates.partials.design', ['certificate' => $certificate])
    </div>

    <div class="mt-12 grid gap-12 md:grid-cols-2">
        <div>
            <h2 class="font-display text-2xl text-[var(--brand)]">Details</h2>
            <dl class="mt-5 space-y-4 text-sm">
                <div class="flex justify-between gap-6 border-b border-[var(--line)] pb-3">
                    <dt class="text-[var(--muted)]">Organization</dt>
                    <dd class="text-right">{{ $certificate->training_organization }}</dd>
                </div>
                <div class="flex justify-between gap-6 border-b border-[var(--line)] pb-3">
                    <dt class="text-[var(--muted)]">Assessor</dt>
                    <dd class="text-right">{{ $certificate->assessor_name }}</dd>
                </div>
                <div class="flex justify-between gap-6 border-b border-[var(--line)] pb-3">
                    <dt class="text-[var(--muted)]">Date</dt>
                    <dd class="text-right">{{ $certificate->date_of_assessment->format('d F Y') }}</dd>
                </div>
                <div class="flex justify-between gap-6 border-b border-[var(--line)] pb-3">
                    <dt class="text-[var(--muted)]">Result</dt>
                    <dd class="text-right font-semibold">{{ $certificate->result }}</dd>
                </div>
                <div class="flex justify-between gap-6">
                    <dt class="text-[var(--muted)]">Status</dt>
                    <dd class="text-right capitalize">{{ $certificate->status }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h2 class="font-display text-2xl text-[var(--brand)]">Comments</h2>

            <form method="POST" action="{{ route('certificates.comments.store', $certificate->slug) }}" class="mt-5 space-y-3">
                @csrf
                <div>
                    <label class="mb-1 block text-sm text-[var(--muted)]">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="field" required>
                    @error('name') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm text-[var(--muted)]">Comment</label>
                    <textarea name="comment" rows="4" class="field" required>{{ old('comment') }}</textarea>
                    @error('comment') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
                <button class="btn-primary">Submit comment</button>
            </form>

            <div class="mt-8 space-y-5">
                @forelse($certificate->approvedComments as $comment)
                    <div class="border-t border-[var(--line)] pt-4">
                        <div class="text-sm font-medium text-[var(--brand)]">{{ $comment->name }}</div>
                        <p class="mt-1 text-sm text-[var(--muted)]">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p class="text-sm text-[var(--muted)]">No approved comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
