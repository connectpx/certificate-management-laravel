@extends('layouts.admin')

@section('page_title', 'Add User')
@section('heading', 'Add User')

@section('content_body')
<div class="card card-outline card-primary">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="card-body">
            @include('admin.users._form')
        </div>
        <div class="card-footer">
            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
