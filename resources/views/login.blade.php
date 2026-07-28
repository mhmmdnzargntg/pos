@extends('layouts.app')

@section('title', 'Ini Halaman Ujicoba')

@section('content')

<div class="card text-center position-absolute top-50 start-50 translate-middle" style="width: 18rem;">
  <div class="card-header">
    Login POS
  </div>
  <div class="card-body">
    <form action="{{ route('auth') }}" method="POST">
        @csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    @error('email')
        <div class="badge text-bg-danger">{{  $message  }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
        @error('password')
        <div class="badge text-bg-danger">{{  $message  }}</div>
    @enderror
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </div>
</div>