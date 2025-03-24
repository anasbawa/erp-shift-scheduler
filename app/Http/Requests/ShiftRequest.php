<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time'   => ['required', 'date_format:H:i', 'before:end_time'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'max_employees' => ['required', 'integer', 'min:1'],
            'department_id' => ['required', Rule::exists(Department::class, 'id')],
            'resources'      => ['nullable', 'array'],
            'resources.*.title' => ['required', 'string'],
        ];
    }
}
