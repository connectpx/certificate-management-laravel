@extends('layouts.admin')

@section('page_title', 'Comments')
@section('heading', 'Comments Moderation')

@section('content_body')
<div class="card card-outline card-primary">
    <div class="card-header">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary">Filter</button>
            </div>
        </form>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped mb-0 align-middle">
            <thead>
                <tr>
                    <th>Certificate</th>
                    <th>Name</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>
                            <a href="{{ route('admin.certificates.show', $comment->certificate) }}">
                                {{ $comment->certificate?->certificate_number }}
                            </a>
                        </td>
                        <td>{{ $comment->name }}</td>
                        <td style="max-width:360px;">{{ $comment->comment }}</td>
                        <td>
                            <span class="badge text-bg-{{ $comment->status === 'approved' ? 'success' : ($comment->status === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($comment->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                @if($comment->isPending())
                                    <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-outline-success"><i class="bi bi-check2"></i></button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Delete comment?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No comments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($comments->hasPages())
        <div class="card-footer">{{ $comments->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@stop
