@extends('adminlte::page')

@section('title')
    @yield('page_title', 'Admin')
@stop

@section('content_header')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <h1 class="m-0">@yield('heading', 'Dashboard')</h1>
        <div>@yield('header_actions')</div>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @yield('content_body')
@stop

@section('footer')
    <strong>BASDU Certificate Management</strong>
    <div class="float-end d-none d-sm-inline">Secure Admin Panel</div>
@stop

@push('css')
<style>
    .small-box .inner h3 { font-size: 2rem; }
    .table thead th { white-space: nowrap; }
    .cert-preview-wrap { overflow-x: auto; background: #f8f9fa; border-radius: .5rem; padding: 1rem; }
</style>
@endpush
