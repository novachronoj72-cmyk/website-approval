<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="text-align: center; color: #4e73df;">Reset Password</h2>
        <p>Halo,</p>
        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
        <p>Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
        
        <div style="background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px; margin: 20px 0; border-radius: 5px;">
            {{ $otp }}
        </div>

        <p>Kode ini akan kadaluarsa dalam 15 menit.</p>
        <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">Aplikasi Approval Pengajuan &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>