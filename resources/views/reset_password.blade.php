@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
    <h3 class="text-center mb-4">Reset Password</h3>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        <!-- OTP -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="otp" name="otp" required autofocus placeholder="Kode OTP" maxlength="6">
            <label for="otp">Kode OTP (dari Email)</label>
        </div>

        <!-- Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" required placeholder="Password Baru">
            <label for="password">Password Baru</label>
        </div>

        <!-- Confirm Password -->
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Konfirmasi Password">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
        </div>
    </form>
@endsection