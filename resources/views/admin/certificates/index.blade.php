@extends('layouts.admin')

@section('page_title', 'Certificates')
@section('heading', 'Certificates')

@section('header_actions')
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Create Certificate
    </a>
@stop

@section('content_body')
<div class="card card-outline card-primary">
    <div class="card-header">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search number, handler, organization...">
                </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary">Search</button>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped mb-0 align-middle">
            <thead>
                <tr>
                    <th>Certificate No</th>
                    <th>Handler Name</th>
                    <th>Organization</th>
                    <th>Result</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($certificates as $certificate)
                    <tr>
                        <td><code>{{ $certificate->certificate_number }}</code></td>
                        <td class="fw-semibold">{{ $certificate->handler_name }}</td>
                        <td>{{ $certificate->training_organization }}</td>
                        <td><span class="badge text-bg-{{ $certificate->isPassed() ? 'success' : 'danger' }}">{{ $certificate->result }}</span></td>
                        <td><span class="badge text-bg-{{ $certificate->isActive() ? 'primary' : 'secondary' }}">{{ ucfirst($certificate->status) }}</span></td>
                        <td>{{ $certificate->date_of_assessment->format('d M Y') }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-outline-secondary" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.certificates.pdf', $certificate) }}" class="btn btn-outline-success" title="PDF"><i class="bi bi-file-earmark-pdf"></i></a>
                                <a href="{{ route('admin.certificates.image', $certificate) }}" class="btn btn-outline-success" title="Image"><i class="bi bi-image"></i></a>
                            </div>
                            <div class="btn-group btn-group-sm ms-1">
                                <form method="POST" action="{{ route('admin.certificates.toggle-status', $certificate) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-outline-warning" title="Toggle status"><i class="bi bi-toggle2-on"></i></button>
                                </form>
                                <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" onsubmit="return confirm('Delete this certificate?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No certificates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($certificates->hasPages())
        <div class="card-footer">{{ $certificates->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@stop
