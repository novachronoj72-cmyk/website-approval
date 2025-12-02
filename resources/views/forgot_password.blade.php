@extends('layouts.guest')

@section('title', 'Lupa Password')

@section('content')
    <h3 class="text-center mb-4">Lupa Password?</h3>
    <p class="text-muted text-center mb-4">Masukkan alamat email Anda dan kami akan mengirimkan kode OTP untuk mereset password Anda.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="form-floating mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com">
            <label for="email">Alamat Email</label>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">Kirim Kode OTP</button>
            <a href="{{ route('login') }}" class="btn btn-light">Kembali ke Login</a>
        </div>
    </form>
@endsection