<?php

namespace App\Http\Requests\Admin;

use App\Models\Certificate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $certificateId = $this->route('certificate')?->id ?? $this->route('certificate');

        return [
            'handler_name' => ['required', 'string', 'max:255'],
            'certificate_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('certificates', 'certificate_number')->ignore($certificateId),
            ],
            'date_of_assessment' => ['required', 'date'],
            'training_organization' => ['required', 'string', 'max:255'],
            'assessor_name' => ['required', 'string', 'max:255'],
            'result' => ['required', Rule::in([Certificate::RESULT_PASS, Certificate::RESULT_FAIL])],
            'status' => ['required', Rule::in([Certificate::STATUS_ACTIVE, Certificate::STATUS_INACTIVE])],
        ];
    }
}
