@extends('layouts.app')

@section('title', 'Evaluation: ' . $evaluation->title)

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <a href="{{ route('evaluation.index') }}" 
               class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 line-clamp-1">
                        {{ $evaluation->title }}
                    </h2>
                    <p class="text-sm text-gray-600">Evaluation #{{ $evaluation->id }}</p>
                </div>
            </div>
        </div>
        <a href="{{ route('evaluation.edit', $evaluation->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Evaluation
        </a>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Evaluation Header --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="space-y-6">
                                {{-- Khmer Section Header --}}
                                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <h3 class="text-lg font-medium text-blue-900 mb-2">
                                        ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
                                    </h3>
                                    <p class="text-sm text-blue-700">
                                        Section 2: Assessment Points, Practical Work Implementation, Additional Comments and Department Head Responses
                                    </p>
                                </div>

                                {{-- Evaluation Title --}}
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900 mb-4">
                                        {{ $evaluation->title }}
                                    </h4>
                                    <div class="prose max-w-none text-gray-700">
                                        <p>
                                            This evaluation form is designed to assess staff performance and gather feedback 
                                            for continuous improvement. The form includes assessment criteria, practical work 
                                            evaluation, and space for additional comments from both evaluators and department heads.
                                        </p>
                                    </div>
                                </div>

                                {{-- Evaluation Stats --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900">{{ $statistics['total_responses'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Total Responses</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900">{{ $evaluation->status ?? 'Active' }}</div>
                                        <div class="text-sm text-gray-600">Status</div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                                        <div class="flex items-center justify-center mb-2">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-gray-900">{{ $evaluation->questions_count ?? 1 }}</div>
                                        <div class="text-sm text-gray-600">Questions</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Evaluation Details --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="border-b border-gray-200 pb-4 mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Evaluation Details</h3>
                                <p class="text-sm text-gray-600">Additional information about this evaluation</p>
                            </div>

                            <div class="space-y-6">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 block mb-2">
                                            Evaluation ID
                                        </label>
                                        <p class="text-sm text-gray-900">#{{ $evaluation->id }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 block mb-2">
                                            Status
                                        </label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $evaluation->status ?? 'Active' }}
                                        </span>
                                    </div>
                                </div>

                                @if($evaluation->description)
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 block mb-2">
                                            Description
                                        </label>
                                        <div class="prose max-w-none text-gray-700">
                                            <p class="text-sm">{{ $evaluation->description }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div>
                                        <label class="text-sm font-medium text-gray-700 block mb-2">
                                            Purpose & Scope
                                        </label>
                                        <div class="prose max-w-none text-gray-700">
                                            <p class="text-sm">
                                                This evaluation is designed to comprehensively assess employee performance, 
                                                identify areas for improvement, and provide constructive feedback for professional 
                                                development. It covers various aspects of job performance including work quality, 
                                                productivity, collaboration, and adherence to organizational values.
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Response Summary --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="border-b border-gray-200 pb-4 mb-6">
                                <h3 class="text-lg font-semibold text-gray-900">Response Summary</h3>
                                <p class="text-sm text-gray-600">Overview of evaluation responses</p>
                            </div>

                            @if(($statistics['total_responses'] ?? 0) > 0)
                                {{-- Show responses if any exist --}}
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div class="bg-blue-50 rounded-lg p-4">
                                            <div class="text-2xl font-bold text-blue-900">{{ $statistics['total_responses'] ?? 0 }}</div>
                                            <div class="text-sm text-blue-600">Total Responses</div>
                                        </div>
                                        <div class="bg-green-50 rounded-lg p-4">
                                            <div class="text-2xl font-bold text-green-900">{{ $statistics['completed_responses'] ?? 0 }}</div>
                                            <div class="text-sm text-green-600">Completed</div>
                                        </div>
                                        <div class="bg-yellow-50 rounded-lg p-4">
                                            <div class="text-2xl font-bold text-yellow-900">{{ $statistics['pending_responses'] ?? 0 }}</div>
                                            <div class="text-sm text-yellow-600">Pending</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Empty state --}}
                                <div class="text-center py-8">
                                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">No Responses Yet</h4>
                                    <p class="text-gray-500 mb-4">
                                        This evaluation hasn't received any responses yet. Once staff members complete the evaluation, 
                                        you'll see summary statistics and insights here.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Creator Information --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Creator Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $evaluation->createdBy->name ?? 'Unknown User' }}
                                        </p>
                                        <p class="text-xs text-gray-500">Created by</p>
                                    </div>
                                </div>
                                @if($evaluation->updatedBy && $evaluation->updatedBy->id !== $evaluation->createdBy->id)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $evaluation->updatedBy->name ?? 'Unknown User' }}
                                            </p>
                                            <p class="text-xs text-gray-500">Last updated by</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Timeline --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Created</p>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m6-6V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7z"></path>
                                            </svg>
                                            {{ $evaluation->created_at ? $evaluation->created_at->format('M d, Y g:i A') : 'Unknown' }}
                                        </p>
                                    </div>
                                </div>
                                @if($evaluation->updated_at && $evaluation->updated_at != $evaluation->created_at)
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                            <p class="text-xs text-gray-500 flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m6-6V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7z"></path>
                                                </svg>
                                                {{ $evaluation->updated_at->format('M d, Y g:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('evaluation.edit', $evaluation->id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Evaluation
                                </a>
                                @if(Route::has('evaluation.analytics'))
                                    <a href="{{ route('evaluation.analytics', $evaluation->id) }}" 
                                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        View Analytics
                                    </a>
                                @else
                                    <button class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all opacity-50 cursor-not-allowed" 
                                            disabled>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        View Analytics
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection