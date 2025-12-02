@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <h3 class="text-center mb-4">Buat Akun Baru</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama Lengkap">
            <label for="name">Nama Lengkap</label>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com">
            <label for="email">Alamat Email</label>
             @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Password">
            <label for="password">Password</label>
             @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi Password">
            <label for="password_confirmation">Konfirmasi Password</label>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Register</button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </form>
@endsection