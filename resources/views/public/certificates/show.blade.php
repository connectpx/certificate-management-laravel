@extends('layouts.public')

@section('title', $certificate->handler_name.' — Certificate')

@section('content')
<section class="site-container section-sm">
    <div class="show-head mb-8 border-b pb-8">
        <div>
            <p class="text-sm muted">{{ $certificate->certificate_number }}</p>
            <h1 class="font-display page-title mt-1">{{ $certificate->handler_name }}</h1>
            <p class="mt-2 text-sm muted">
                {{ $certificate->training_organization }} ·
                <span class="{{ $certificate->isPassed() ? 'status-pass' : 'status-fail' }}">{{ $certificate->result }}</span>
            </p>
        </div>
        <div class="actions mt-4">
            <a href="{{ route('certificates.pdf', $certificate->slug) }}" class="btn-primary">Download PDF</a>
            <a href="{{ route('certificates.image', $certificate->slug) }}" class="btn-secondary">Download Image</a>
            <a href="{{ route('verify.show', $certificate->slug) }}" class="btn-secondary">Verify</a>
        </div>
    </div>

    <div class="preview-box overflow-x">
        @include('certificates.partials.design', ['certificate' => $certificate])
    </div>

    <div class="grid-2 mt-12">
        <div>
            <h2 class="font-display section-title">Details</h2>
            <dl class="mt-5 stack text-sm">
                <div class="detail-row"><dt class="muted">Organization</dt><dd class="text-right">{{ $certificate->training_organization }}</dd></div>
                <div class="detail-row"><dt class="muted">Assessor</dt><dd class="text-right">{{ $certificate->assessor_name }}</dd></div>
                <div class="detail-row"><dt class="muted">Date</dt><dd class="text-right">{{ $certificate->date_of_assessment->format('d F Y') }}</dd></div>
                <div class="detail-row"><dt class="muted">Result</dt><dd class="text-right font-semibold">{{ $certificate->result }}</dd></div>
                <div class="detail-row"><dt class="muted">Status</dt><dd class="text-right capitalize">{{ $certificate->status }}</dd></div>
            </dl>
        </div>

        <div>
            <h2 class="font-display section-title">Comments</h2>

            <form method="POST" action="{{ route('certificates.comments.store', $certificate->slug) }}" class="mt-5 stack">
                @csrf
                <div>
                    <label class="text-sm muted">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="field mt-1" required>
                    @error('name') <p class="mt-1 text-sm" style="color:#be123c;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm muted">Comment</label>
                    <textarea name="comment" rows="4" class="field mt-1" required>{{ old('comment') }}</textarea>
                    @error('comment') <p class="mt-1 text-sm" style="color:#be123c;">{{ $message }}</p> @enderror
                </div>
                <button class="btn-primary">Submit comment</button>
            </form>

            <div class="mt-8 stack">
                @forelse($certificate->approvedComments as $comment)
                    <div class="border-t pt-4">
                        <div class="text-sm font-medium" style="color: var(--brand);">{{ $comment->name }}</div>
                        <p class="mt-1 text-sm muted">{{ $comment->comment }}</p>
                    </div>
                @empty
                    <p class="text-sm muted">No approved comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
