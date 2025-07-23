@extends('layouts.authenticated')

@section('title', 'Edit Evaluation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-bold text-gray-900">Edit Evaluation</h1>
                <p class="mt-2 text-sm text-gray-700">Update the employee evaluation</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('evaluation-room.show', $evaluation) }}" 
                   class="inline-flex items-center justify-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Evaluation
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mt-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were some errors with your submission</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Evaluation Form -->
        <form action="{{ route('evaluation-room.update', $evaluation) }}" method="POST" class="mt-8 space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Employee Information Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Employee Information</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <label for="searchId" class="block text-sm font-medium text-gray-700">Employee ID <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="model_data[searchId]" 
                                       id="searchId" 
                                       value="{{ old('model_data.searchId', $evaluation->user_id) }}"
                                       required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('model_data.searchId') border-red-300 @enderror">
                            </div>
                            @error('model_data.searchId')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="employeeName" class="block text-sm font-medium text-gray-700">Employee Name</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="model_data[employeeName]" 
                                       id="employeeName" 
                                       value="{{ old('model_data.employeeName', $evaluation->user->name ?? '') }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="jobTitle" class="block text-sm font-medium text-gray-700">Job Title</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="model_data[jobTitle]" 
                                       id="jobTitle" 
                                       value="{{ old('model_data.jobTitle', $evaluation->user->position->name ?? '') }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="model_data[department]" 
                                       id="department" 
                                       value="{{ old('model_data.department', $evaluation->user->department->name ?? '') }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="monthlyPerformance" class="block text-sm font-medium text-gray-700">Monthly Performance</label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="model_data[monthlyPerformance]" 
                                       id="monthlyPerformance" 
                                       value="{{ old('model_data.monthlyPerformance', $evaluation->monthly_performance) }}"
                                       placeholder="Staff Performance"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="evaluationDate" class="block text-sm font-medium text-gray-700">Evaluation Date <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="date" 
                                       name="model_data[evaluationDate]" 
                                       id="evaluationDate" 
                                       value="{{ old('model_data.evaluationDate', $evaluation->evaluation_date ? $evaluation->evaluation_date->format('Y-m-d') : '') }}"
                                       required
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error('model_data.evaluationDate') border-red-300 @enderror">
                            </div>
                            @error('model_data.evaluationDate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Type Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Evaluation Type</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input id="type-self" 
                                       name="evaluation_type" 
                                       type="radio" 
                                       value="self" 
                                       {{ old('evaluation_type', $evaluation->evaluation_type) === 'self' ? 'checked' : '' }}
                                       class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                <label for="type-self" class="ml-3 block text-sm font-medium text-gray-700">
                                    <div>ការវាយតម្លៃខ្លួនឯង</div>
                                    <div class="text-xs text-gray-500">Self Evaluation</div>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="type-staff" 
                                       name="evaluation_type" 
                                       type="radio" 
                                       value="staff" 
                                       {{ old('evaluation_type', $evaluation->evaluation_type) === 'staff' ? 'checked' : '' }}
                                       class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                <label for="type-staff" class="ml-3 block text-sm font-medium text-gray-700">
                                    <div>ការវាយតម្លៃបុគ្គលិក</div>
                                    <div class="text-xs text-gray-500">Staff Evaluation</div>
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input id="type-final" 
                                       name="evaluation_type" 
                                       type="radio" 
                                       value="final" 
                                       {{ old('evaluation_type', $evaluation->evaluation_type) === 'final' ? 'checked' : '' }}
                                       class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                <label for="type-final" class="ml-3 block text-sm font-medium text-gray-700">
                                    <div>ការវាយតម្លៃចុងក្រោយ</div>
                                    <div class="text-xs text-gray-500">Final Evaluation</div>
                                </label>
                            </div>
                        </div>
                        @error('evaluation_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Evaluation Criteria Section -->
            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Evaluation Criteria</h3>
                        <div class="text-sm text-gray-600">
                            <div>តម្លៃលេខ ១-៥</div>
                            <div>Performance Rating 1-5</div>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">
                        <span class="font-medium">Section 2:</span> Evaluation points in practice - Comments and feedback by Supervisor/Manager
                    </p>
                </div>
                <div class="px-6 py-4 space-y-6">
                    @php
                        // Create a map of existing criteria responses for easy lookup
                        $existingResponses = $evaluation->criteriaResponses->keyBy('evaluation_criteria_id');
                    @endphp
                    
                    @forelse($criteria as $index => $criterion)
                        @php
                            $existingResponse = $existingResponses->get($criterion->id);
                        @endphp
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="mb-3">
                                <h4 class="font-medium text-gray-900">{{ $criterion->title }}</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                                <div class="lg:col-span-3">
                                    <label for="feedback_{{ $criterion->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        យោបល់/Comments & feedback:
                                    </label>
                                    <textarea name="evaluation[child_evaluations][{{ $index }}][feedback]" 
                                              id="feedback_{{ $criterion->id }}"
                                              rows="3"
                                              placeholder="Write feedback here..."
                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">{{ old("evaluation.child_evaluations.{$index}.feedback", $existingResponse->feedback ?? '') }}</textarea>
                                </div>
                                
                                <div>
                                    <label for="rating_{{ $criterion->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Rating <span class="text-red-500">*</span>
                                    </label>
                                    <select name="evaluation[child_evaluations][{{ $index }}][rating]" 
                                            id="rating_{{ $criterion->id }}"
                                            required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm @error("evaluation.child_evaluations.{$index}.rating") border-red-300 @enderror">
                                        <option value="">Select</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" 
                                                {{ old("evaluation.child_evaluations.{$index}.rating", $existingResponse->rating ?? '') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error("evaluation.child_evaluations.{$index}.rating")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Hidden field for evaluation_id -->
                            <input type="hidden" name="evaluation[child_evaluations][{{ $index }}][evaluation_id]" value="{{ $criterion->id }}">
                        </div>
                    @empty
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No evaluation criteria found</h3>
                        <p class="mt-1 text-sm text-gray-500">Please create evaluation criteria templates first.</p>
                        <div class="mt-6">
                            <a href="{{ route('evaluation.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700">
                                Create Evaluation Template
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Action Buttons -->
            @if($criteria->count() > 0)
            <div class="flex justify-end space-x-3">
                <a href="{{ route('evaluation-room.show', $evaluation) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Evaluation
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection 