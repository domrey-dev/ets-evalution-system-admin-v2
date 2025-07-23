<?php

namespace App\Http\Requests\EvaluationRoom;

use Illuminate\Foundation\Http\FormRequest;

class EvaluationRoomRequest extends FormRequest
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
            'model_data' => 'required|array',
            'model_data.searchId' => 'required|exists:users,id',
            'model_data.monthlyPerformance' => 'nullable|string|max:255',
            'model_data.evaluationDate' => 'required|date',
            'model_data.employeeName' => 'nullable|string|max:255',
            'model_data.jobTitle' => 'nullable|string|max:255',
            'model_data.department' => 'nullable|string|max:255',
            
            'evaluation_type' => 'required|in:staff,self,final',
            
            'evaluation' => 'required|array',
            'evaluation.child_evaluations' => 'required|array|min:1',
            'evaluation.child_evaluations.*.evaluation_id' => 'required|exists:evaluation_criteria,id',
            'evaluation.child_evaluations.*.feedback' => 'nullable|string',
            'evaluation.child_evaluations.*.rating' => 'required|integer|min:1|max:5',
            
            // Section 3: Summary fields
            'summary' => 'required|array',
            'summary.improvement_points' => 'nullable|string',
            'summary.total_score' => 'required|integer|min:0|max:50', // Will be stored in monthly_performance
            'summary.grade' => 'required|in:A,B,C,D,E',
            'summary.evaluator_name' => 'required|string|max:255',
            'summary.evaluation_date' => 'required|date',
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
            'model_data.searchId.required' => 'Employee ID is required.',
            'model_data.searchId.exists' => 'Selected employee does not exist.',
            'model_data.evaluationDate.required' => 'Evaluation date is required.',
            'model_data.evaluationDate.date' => 'Evaluation date must be a valid date.',
            
            'evaluation_type.required' => 'Evaluation type is required.',
            'evaluation_type.in' => 'Evaluation type must be staff, self, or final.',
            
            'evaluation.child_evaluations.required' => 'At least one evaluation criteria is required.',
            'evaluation.child_evaluations.min' => 'At least one evaluation criteria is required.',
            'evaluation.child_evaluations.*.evaluation_id.required' => 'Evaluation criteria ID is required.',
            'evaluation.child_evaluations.*.evaluation_id.exists' => 'Selected evaluation criteria does not exist.',
            'evaluation.child_evaluations.*.rating.required' => 'Rating is required for each criteria.',
            'evaluation.child_evaluations.*.rating.integer' => 'Rating must be a number.',
            'evaluation.child_evaluations.*.rating.min' => 'Rating must be at least 1.',
            'evaluation.child_evaluations.*.rating.max' => 'Rating cannot be more than 5.',
        ];
    }
} 