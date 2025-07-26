<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'staff_code' => ['required', 'string', 'unique:staffs,staff_code'],
            'en_name' => ['required', 'string', 'max:255'],
            'kh_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'email' => ['required', 'email', 'unique:staffs,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'in:Male,Female'],
            'work_contract' => ['required', 'in:Permanent,Project-based,Internship,Subcontract'],
            'start_of_work' => ['required', 'date'],
            'department_id' => ['required', 'exists:department,id'],
            'position_id' => ['required', 'exists:position,id'],
            'project_id' => ['nullable', 'exists:projects,id'],
        ];
    }
}
