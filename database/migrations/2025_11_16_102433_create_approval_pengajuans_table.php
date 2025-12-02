<?php

use App\Enums\ApprovalStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_pengajuan', function (Blueprint $table) {
            $table->id();
            // Relasi One-to-One dengan pengajuan
            $table->foreignId('pengajuan_id')->constrained('pengajuan')->onDelete('cascade')->unique();
             // admin_id merujuk ke tabel users
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->text('catatan_admin')->nullable();
            $table->string('status_approval'); // 'approved', 'rejected'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_pengajuan');
    }
};