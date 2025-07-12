@extends('layouts.app')

@section('title', 'Create Evaluation')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('evaluation.index') }}" 
               class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Create New Evaluation</h2>
                <p class="text-sm text-gray-600 mt-1">
                    Create a new evaluation form for staff assessment
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span>New Evaluation</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('evaluation.store') }}" class="space-y-6">
                @csrf
                
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
                                    <p class="text-sm text-gray-600">Basic information about the evaluation form</p>
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
                                        value="{{ old('title') }}"
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
                                    >{{ old('description') }}</textarea>
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

                {{-- Form Actions --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
                    <div class="text-sm text-gray-500">
                        <span class="font-medium">Note:</span> You can edit this evaluation after creating it.
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('evaluation.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            Cancel
                        </a>
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all create-evaluation-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="btn-text">Create Evaluation</span>
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
            const submitBtn = document.querySelector('.create-evaluation-btn');
            
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                // Replace button content with loading state
                submitBtn.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        <span>Creating...</span>
                    </div>
                `;
            });
        });
    </script>
@endsection