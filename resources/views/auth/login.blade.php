@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h3 class="text-center mb-4">Login Akun</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com">
            <label for="email">Alamat Email</label>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password">
            <label for="password">Password</label>
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Ingat Saya
                </label>
            </div>
            <a href="#">Lupa Password?</a>
        </div>


        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Login</button>
        </div>

        <hr class="my-4">

        <div class="text-center">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </form>
@endsection