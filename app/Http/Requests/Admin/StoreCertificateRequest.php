<?php

namespace App\Http\Requests\Admin;

use App\Models\Certificate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function prepareForValidation(): void
    {
        if ($this->certificate_number === '') {
            $this->merge(['certificate_number' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'handler_name' => ['required', 'string', 'max:255'],
            'certificate_number' => ['nullable', 'string', 'max:100', 'unique:certificates,certificate_number'],
            'date_of_assessment' => ['required', 'date'],
            'training_organization' => ['required', 'string', 'max:255'],
            'assessor_name' => ['required', 'string', 'max:255'],
            'result' => ['required', Rule::in([Certificate::RESULT_PASS, Certificate::RESULT_FAIL])],
            'status' => ['required', Rule::in([Certificate::STATUS_ACTIVE, Certificate::STATUS_INACTIVE])],
        ];
    }
}
