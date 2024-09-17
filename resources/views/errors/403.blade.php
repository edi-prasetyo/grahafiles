@extends('layouts.app')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

@section('content')
    <div class="container">
        <div class="alert alert-danger mt-5">Anda tidak memiliki akses halaman ini</div>
    </div>
@endsection
