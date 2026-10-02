@extends('layouts.admin')

@section('page_title', 'Certificate '.$certificate->certificate_number)
@section('heading', 'Certificate Details')

@section('header_actions')
    <div class="btn-group">
        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-primary"><i class="bi bi-pencil"></i> Edit</a>
        <a href="{{ route('admin.certificates.pdf', $certificate) }}" class="btn btn-outline-success"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
        <a href="{{ route('admin.certificates.image', $certificate) }}" class="btn btn-outline-success"><i class="bi bi-image"></i> Image</a>
        <a href="{{ route('verify.show', $certificate->slug) }}" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-shield-check"></i> Verify</a>
    </div>
@stop

@section('content_body')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card card-outline card-secondary h-100">
            <div class="card-header"><h3 class="card-title">Summary</h3></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5">Handler</dt><dd class="col-7">{{ $certificate->handler_name }}</dd>
                    <dt class="col-5">Number</dt><dd class="col-7"><code>{{ $certificate->certificate_number }}</code></dd>
                    <dt class="col-5">Organization</dt><dd class="col-7">{{ $certificate->training_organization }}</dd>
                    <dt class="col-5">Assessor</dt><dd class="col-7">{{ $certificate->assessor_name }}</dd>
                    <dt class="col-5">Date</dt><dd class="col-7">{{ $certificate->date_of_assessment->format('d F Y') }}</dd>
                    <dt class="col-5">Result</dt>
                    <dd class="col-7"><span class="badge text-bg-{{ $certificate->isPassed() ? 'success' : 'danger' }}">{{ $certificate->result }}</span></dd>
                    <dt class="col-5">Status</dt>
                    <dd class="col-7"><span class="badge text-bg-{{ $certificate->isActive() ? 'primary' : 'secondary' }}">{{ ucfirst($certificate->status) }}</span></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card card-outline card-primary" x-data="{ copied: false }">
            <div class="card-header"><h3 class="card-title">Verification URL</h3></div>
            <div class="card-body">
                <div class="input-group">
                    <input type="text" readonly class="form-control" id="verify-url" value="{{ $certificate->verify_url }}">
                    <button type="button" class="btn btn-warning"
                            @click="navigator.clipboard.writeText(document.getElementById('verify-url').value); copied = true; setTimeout(() => copied = false, 1500)">
                        <span x-text="copied ? 'Copied!' : 'Copy Link'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card card-outline card-dark">
            <div class="card-header"><h3 class="card-title">Certificate Preview</h3></div>
            <div class="card-body cert-preview-wrap">
                @include('certificates.partials.design', ['certificate' => $certificate])
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card card-outline card-info">
            <div class="card-header"><h3 class="card-title">Comments</h3></div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($certificate->comments as $comment)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $comment->name }}</strong>
                                <span class="badge text-bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'pending' ? 'warning' : 'secondary') }}">{{ $comment->status }}</span>
                            </div>
                            <div class="text-muted small mt-1">{{ $comment->comment }}</div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No comments yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
