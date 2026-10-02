@extends('layouts.admin')

@section('page_title', 'Dashboard')
@section('heading', 'Dashboard')

@section('header_actions')
    <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> New Certificate
    </a>
@stop

@section('content_body')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $stats['certificates'] }}</h3>
                <p>Total Certificates</p>
            </div>
            <div class="small-box-icon"><i class="bi bi-award"></i></div>
            <a href="{{ route('admin.certificates.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                View all <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $stats['active_certificates'] }}</h3>
                <p>Active Certificates</p>
            </div>
            <div class="small-box-icon"><i class="bi bi-shield-check"></i></div>
            <a href="{{ route('admin.certificates.index') }}" class="small-box-footer link-light link-underline-opacity-0">
                Manage <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $stats['users'] }}</h3>
                <p>Admin Users</p>
            </div>
            <div class="small-box-icon"><i class="bi bi-people"></i></div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer link-dark link-underline-opacity-0">
                Manage users <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ $stats['pending_comments'] }}</h3>
                <p>Pending Comments</p>
            </div>
            <div class="small-box-icon"><i class="bi bi-chat-dots"></i></div>
            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="small-box-footer link-light link-underline-opacity-0">
                Moderate <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
</div>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="bi bi-clock-history me-1"></i> Recent Certificates</h3>
        <div class="card-tools">
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-tool">View all</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped mb-0">
            <thead>
                <tr>
                    <th>Certificate No</th>
                    <th>Handler</th>
                    <th>Result</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentCertificates as $certificate)
                    <tr>
                        <td><code>{{ $certificate->certificate_number }}</code></td>
                        <td>{{ $certificate->handler_name }}</td>
                        <td>
                            <span class="badge text-bg-{{ $certificate->isPassed() ? 'success' : 'danger' }}">
                                {{ $certificate->result }}
                            </span>
                        </td>
                        <td>
                            <span class="badge text-bg-{{ $certificate->isActive() ? 'primary' : 'secondary' }}">
                                {{ ucfirst($certificate->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-sm btn-outline-primary">
                                Open
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No certificates yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
