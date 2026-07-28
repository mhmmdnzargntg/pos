@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<h1>TESTTTTTTTTTTTTTTTTTT</h1>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    @include('users._form')
</form>
@endsection