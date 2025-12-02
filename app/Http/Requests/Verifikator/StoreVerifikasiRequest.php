<?php

namespace App\Http\Requests\Verifikator;

use App\Enums\VerifikasiStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVerifikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isVerifikator();
    }

    public function rules(): array
    {
        return [
            // Rule::enum akan memastikan input adalah salah satu dari: 'verified' atau 'rejected'
            'status_verifikasi' => ['required', Rule::enum(VerifikasiStatus::class)],
            'catatan_verifikasi' => ['nullable', 'string', 'max:1000'],
        ];
    }
}