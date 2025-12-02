<?php

use App\Enums\PengajuanStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_pengajuan')->onDelete('restrict');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable(); // Path ke file
            $table->string('status')->default(PengajuanStatus::PENDING->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};