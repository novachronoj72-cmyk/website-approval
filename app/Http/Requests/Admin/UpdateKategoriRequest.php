<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Dapatkan ID kategori dari route
        $kategoriId = $this->route('kategori')->id;

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori_pengajuan')->ignore($kategoriId),
            ],
            'deskripsi' => 'nullable|string|max:1000',
        ];
    }
}