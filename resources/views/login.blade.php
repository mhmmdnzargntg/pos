@extends('layouts.app')
 
@section('title', 'Login POS')
 
@section('content')
 
<div class="d-flex align-items-center justify-content-center vh-100">
 
    <div class="card shadow-sm border-0" style="width: 22rem; border-radius: 1rem;">
 
        {{-- Header --}}
        <div class="card-header bg-primary text-white text-center py-3" style="border-radius: 1rem 1rem 0 0;">
            <h5 class="mb-0">Login POS</h5>
        </div>
 
        <div class="card-body p-4">
 
            {{-- Notifikasi sukses (misal setelah logout) --}}
            @if (session('status'))
                <div class="alert alert-success py-2 small" role="alert">
                    {{ session('status') }}
                </div>
            @endif
 
            <form action="{{ route('auth') }}" method="POST">
                @csrf
 
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        id="exampleInputEmail1"
                        placeholder="nama@email.com"
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
 
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="exampleInputPassword1"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
 
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                    <label class="form-check-label small" for="rememberMe">Ingat saya</label>
                </div>
 
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
 
        </div>
    </div>
 
</div>
 
@endsection
 