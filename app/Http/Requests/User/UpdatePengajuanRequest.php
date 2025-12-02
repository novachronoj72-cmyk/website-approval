<?php

namespace App\Http\Requests\User;

use App\Enums\PengajuanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pengajuan = $this->route('pengajuan');
        
        // Hanya boleh update punya sendiri DAN status masih pending
        return $this->user()->id === $pengajuan->user_id 
            && $pengajuan->status === PengajuanStatus::PENDING;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengajuan,id',
            'deskripsi' => 'required|string',
            'lampiran' => [
                'nullable',
                File::types(['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])->max(2048)
            ],
        ];
    }
}