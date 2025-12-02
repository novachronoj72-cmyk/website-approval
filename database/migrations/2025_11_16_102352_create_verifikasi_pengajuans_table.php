<?php

use App\Enums\VerifikasiStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_pengajuan', function (Blueprint $table) {
            $table->id();
            // Relasi One-to-One dengan pengajuan
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade')->unique();
            // verifikator_id merujuk ke tabel users
            $table->foreignId('verifikator_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan_verifikasi')->nullable();
            $table->string('status_verifikasi'); // 'verified', 'rejected'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_pengajuan');
    }
};