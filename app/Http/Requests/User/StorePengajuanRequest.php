<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isUser();
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_pengajuan,id',
            'deskripsi' => 'required|string',
            // Validasi File: PDF, Doc, Gambar, Max 2MB
            'lampiran' => [
                'nullable',
                File::types(['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'])->max(2048)
            ],
        ];
    }
}