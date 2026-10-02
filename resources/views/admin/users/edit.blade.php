@extends('layouts.admin')

@section('page_title', 'Edit User')
@section('heading', 'Edit User')

@section('content_body')
<div class="card card-outline card-primary">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            @include('admin.users._form', ['user' => $user])
        </div>
        <div class="card-footer">
            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop
