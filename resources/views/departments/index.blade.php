{{-- resources/views/projects/index.blade.php --}}
@extends('layouts.authenticated')

@section('title', 'Projects')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Projects</h2>
            <p class="text-sm text-gray-600 mt-1">
                Manage and track your projects
            </p>
        </div>
        <a href="{{ route('project.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Project
        </a>
    </div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($projects->hasPages())
            <div class="mt-6">
                {{ $projects->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection