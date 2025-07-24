@extends('layouts.authenticated')

@section('title', 'Edit Evaluation Template')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Evaluation Template</h2>
            <p class="text-sm text-gray-600 mt-1">
                             Edit "{{ $evaluation->title }}"
         </p>
     </div>
     <a href="{{ route('evaluation.show', $evaluation) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Template
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('evaluation.update', $evaluation) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Template Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Template Title *
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $evaluation->title) }}" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title') border-red-500 @enderror"
                    placeholder="e.g., Annual Performance Evaluation, Quarterly Review"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Give your evaluation template a descriptive name
                </p>
            </div>

            <!-- Template Statistics -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Template Information</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Criteria:</span>
                        <span class="font-medium text-gray-900">{{ $evaluation->criteria->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Responses:</span>
                        <span class="font-medium text-gray-900">{{ $evaluation->evaluationSummaries->count() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="font-medium text-gray-900">{{ $evaluation->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Updated:</span>
                        <span class="font-medium text-gray-900">{{ $evaluation->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">
                            Manage Criteria
                        </h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>After updating this template, you can:</p>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>Add new evaluation criteria</li>
                                <li>Edit existing criteria</li>
                                <li>Reorder criteria</li>
                                <li>Preview the complete form</li>
                            </ul>
                        </div>
                                                 <div class="mt-3">
                             <a href="{{ route('evaluation.show', $evaluation) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                Go to criteria management →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

                         <!-- Actions -->
             <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                 <a href="{{ route('evaluation.show', $evaluation) }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors">
                    Update Template
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 