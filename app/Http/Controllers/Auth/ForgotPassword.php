<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class ForgotPasswordController extends Controller
{
    // Tampilkan form input email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        
        // Generate OTP 6 digit
        $otp = strtoupper(Str::random(6));
        
        // Simpan ke database dengan expired 15 menit
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        // Kirim Email (Pastikan konfigurasi SMTP di .env sudah benar)
        try {
            Mail::to($user->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Cek konfigurasi mail server.']);
        }

        // Redirect ke halaman input OTP & Password Baru
        return redirect()->route('password.reset.form', ['email' => $user->email]);
    }

    // Tampilkan form reset password (input OTP & password baru)
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->query('email')]);
    }

    // Proses Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();

        // Validasi OTP
        if ($user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Validasi Expired
        if ($user->otp_expires_at < now()) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan minta ulang.']);
        }

        // Reset Password
        $user->update([
            'password' => Hash::make($request->password),
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
    }
}