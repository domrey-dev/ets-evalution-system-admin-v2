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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'staff_id' => ['required|exists:staff,id'],
            'en_name' => ['required|string'],
            'kh_name' => ['required|string'],
            'gender' => ['required|in:male,female'],
            'work_contract' => ['required|in:full_time,part_time,contract'],
            'start_date' => ['required|date'],
            'status' => ['required|in:active,inactive'],
        ];
    }
}
