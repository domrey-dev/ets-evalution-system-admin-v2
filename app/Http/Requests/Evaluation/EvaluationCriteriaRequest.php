<?php

namespace App\Http\Requests\Evaluation;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationCriteriaRequest extends FormRequest
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
            'evaluation_id' => 'required|exists:evaluations,id',
            'title_kh' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_kh' => 'required|string',
            'description_en' => 'required|string',
            'order_number' => 'required|integer|min:1|max:100',
            'weight' => 'nullable|numeric|min:0|max:10',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'evaluation_id.required' => 'Evaluation template is required.',
            'evaluation_id.exists' => 'Selected evaluation template does not exist.',
            'title_kh.required' => 'Khmer title is required.',
            'title_en.required' => 'English title is required.',
            'description_kh.required' => 'Khmer description is required.',
            'description_en.required' => 'English description is required.',
            'order_number.required' => 'Order number is required.',
            'order_number.min' => 'Order number must be at least 1.',
            'order_number.max' => 'Order number cannot exceed 100.',
            'weight.numeric' => 'Weight must be a number.',
            'weight.min' => 'Weight cannot be negative.',
            'weight.max' => 'Weight cannot exceed 10.',
        ];
    }
} 