@extends('layouts.app')

@section('title', 'Edit Evaluation: ' . $evaluation->title)

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('evaluation.show', $evaluation->id) }}" 
               class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Evaluation</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Update the evaluation form details
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Editing #{{ $evaluation->id }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('evaluation.update', $evaluation->id) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                {{-- Evaluation Information Section --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Evaluation Information</h3>
                                    <p class="text-sm text-gray-600">Update the evaluation form details</p>
                                </div>
                            </div>
                        </div>

                        {{-- Current Evaluation Info --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900">Current Evaluation</h4>
                                    <p class="text-sm text-gray-600">#{{ $evaluation->id }} - {{ $evaluation->title }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Khmer Header --}}
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <h4 class="text-lg font-medium text-blue-900 mb-2">
                                ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
                            </h4>
                            <p class="text-sm text-blue-700">
                                Section 2: Assessment Points, Practical Work Implementation, Additional Comments and Department Head Responses
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            {{-- Evaluation Title --}}
                            <div>
                                <label for="evaluation_title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Evaluation Title / កម្រងសំណួរទី
                                </label>
                                <div class="relative">
                                    <input 
                                        type="text"
                                        id="evaluation_title"
                                        name="title"
                                        value="{{ old('title', $evaluation->title) }}"
                                        class="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                        placeholder="Enter evaluation title (e.g., Monthly Performance Review, Annual Assessment)"
                                        required
                                        autofocus
                                    />
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    Choose a descriptive title that clearly identifies the purpose and scope of this evaluation.
                                </p>
                            </div>

                            {{-- Optional: Description Field --}}
                            <div>
                                <label for="evaluation_description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description (Optional)
                                </label>
                                <div class="relative">
                                    <textarea 
                                        id="evaluation_description"
                                        name="description"
                                        rows="4"
                                        class="mt-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                        placeholder="Provide additional details about this evaluation's purpose, scope, or instructions..."
                                    >{{ old('description', $evaluation->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    Optional: Provide additional context or instructions for this evaluation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Evaluation Metadata --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Evaluation Metadata</h3>
                            <p class="text-sm text-gray-600">Information about this evaluation's history</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">
                                    Created By
                                </label>
                                <p class="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                                    {{ $evaluation->createdBy->name ?? 'Unknown User' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">
                                    Last Updated By
                                </label>
                                <p class="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                                    {{ $evaluation->updatedBy->name ?? 'Unknown User' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">
                                    Created Date
                                </label>
                                <p class="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                                    {{ $evaluation->created_at ? $evaluation->created_at->format('M d, Y g:i A') : 'Unknown' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-700 block mb-2">
                                    Last Updated
                                </label>
                                <p class="text-sm text-gray-900 p-3 bg-gray-50 rounded-lg">
                                    {{ $evaluation->updated_at ? $evaluation->updated_at->format('M d, Y g:i A') : 'Unknown' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Note:</span> Changes will be saved immediately upon submission.
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('evaluation.show', $evaluation->id) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all update-evaluation-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="btn-text">Update Evaluation</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Loading State Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.update-evaluation-btn');
            
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                // Replace button content with loading state
                submitBtn.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        <span>Updating...</span>
                    </div>
                `;
            });
        });
    </script>
@endsection