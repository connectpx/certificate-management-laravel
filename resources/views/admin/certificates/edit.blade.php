@extends('layouts.admin')

@section('page_title', 'Edit Certificate')
@section('heading', 'Edit Certificate')

@section('content_body')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">{{ $certificate->certificate_number }}</h3></div>
    <form method="POST" action="{{ route('admin.certificates.update', $certificate) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.certificates._form', ['certificate' => $certificate])
        </div>
        <div class="card-footer">
            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Update Certificate</button>
            <a href="{{ route('admin.certificates.show', $certificate) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
