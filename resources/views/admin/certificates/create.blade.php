@extends('layouts.admin')

@section('page_title', 'Create Certificate')
@section('heading', 'Create Certificate')

@section('content_body')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">Certificate Details</h3></div>
    <form method="POST" action="{{ route('admin.certificates.store') }}">
        @csrf
        <div class="card-body">
            @include('admin.certificates._form', ['suggestedNumber' => $suggestedNumber])
        </div>
        <div class="card-footer">
            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Create Certificate</button>
            <a href="{{ route('admin.certificates.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
