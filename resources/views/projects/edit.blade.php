{{-- resources/views/projects/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Project - ' . $project->name)

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Project</h2>
            <p class="text-sm text-gray-600 mt-1">
                Update "{{ $project->name }}" project details
            </p>
        </div>
        <a
            href="{{ route('project.show', $project->id) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200"
        >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Cancel
        </a>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <form method="POST" action="{{ route('project.update', $project->id) }}" enctype="multipart/form-data" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')
                
                {{-- Current Image Preview --}}
                @if($project->image_path)
                    <div class="p-6 bg-gray-50">
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Current Image</h3>
                            <div class="relative inline-block">
                                <img 
                                    src="{{ Storage::url($project->image_path) }}" 
                                    alt="{{ $project->name }}"
                                    class="w-48 h-32 object-cover rounded-lg shadow-sm border border-gray-200" 
                                />
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Project Image Section --}}
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                {{ $project->image_path ? 'Update Project Image' : 'Add Project Image' }}
                            </h3>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label
                                            for="project_image_path"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500"
                                        >
                                            <span>{{ $project->image_path ? 'Replace image' : 'Upload a file' }}</span>
                                            <input
                                                id="project_image_path"
                                                name="image"
                                                type="file"
                                                class="sr-only"
                                                accept="image/*"
                                            />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Project Details Section --}}
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Project Details</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Project Name --}}
                            <div class="md:col-span-2">
                                <label for="project_name" class="text-sm font-medium text-gray-700">
                                    Project Name <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input
                                        id="project_name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name', $project->name) }}"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('name') border-red-300 @enderror"
                                        placeholder="Enter project name"
                                        required
                                        autofocus
                                    />
                                </div>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Due Date --}}
                            <div>
                                <label for="project_due_date" class="text-sm font-medium text-gray-700">
                                    Due Date
                                </label>
                                <div class="mt-1 relative">
                                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input
                                        id="project_due_date"
                                        type="date"
                                        name="due_date"
                                        {{-- value="{{ old('due_date', $project->due_date ? $project->due_date->format('Y-m-d') : '') }}" --}}
                                        value="{{ old('due_date', $project->due_date ? \Carbon\Carbon::parse($project->due_date)->format('Y-m-d') : '') }}"
                                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('due_date') border-red-300 @enderror"
                                    />
                                </div>
                                @error('due_date')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Project Status --}}
                            <div>
                                <label for="project_status" class="text-sm font-medium text-gray-700">
                                    Project Status <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select
                                        name="status"
                                        id="project_status"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('status') border-red-300 @enderror"
                                        required
                                    >
                                        <option value="">Select Status</option>
                                        <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                                @error('status')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Project Description --}}
                            <div class="md:col-span-2">
                                <label for="project_description" class="text-sm font-medium text-gray-700">
                                    Project Description
                                </label>
                                <div class="mt-1 relative">
                                    <div class="absolute left-3 top-3 text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <textarea
                                        id="project_description"
                                        name="description"
                                        rows="4"
                                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('description') border-red-300 @enderror"
                                        placeholder="Describe your project goals, requirements, and key details..."
                                    >{{ old('description', $project->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="px-6 py-4 bg-gray-50">
                    <div class="flex items-center justify-end space-x-3">
                        <a
                            href="{{ route('project.show', $project->id) }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Update Project
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Optional: Add form enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on first input
    const firstInput = document.getElementById('project_name');
    if (firstInput) {
        firstInput.focus();
    }
    
    // Form submission handler
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating...
                `;
                submitButton.disabled = true;
            }
        });
    }
    
    // Image preview functionality
    const imageInput = document.getElementById('project_image_path');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview if it doesn't exist
                    let preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.id = 'image-preview';
                        preview.className = 'mt-4';
                        imageInput.closest('.space-y-6').appendChild(preview);
                    }
                    
                    preview.innerHTML = `
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700">New Image Preview:</p>
                            <img src="${e.target.result}" alt="Preview" class="w-48 h-32 object-cover rounded-lg shadow-sm border border-gray-200">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
@endsection