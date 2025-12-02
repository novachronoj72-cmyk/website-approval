<?php

namespace App\Http\Requests\Admin;

use App\Enums\ApprovalStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApprovalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status_approval' => ['required', Rule::enum(ApprovalStatus::class)],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ];
    }
}