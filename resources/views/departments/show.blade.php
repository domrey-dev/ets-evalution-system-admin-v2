@extends('layouts.app')

@section('title', 'Department "' . $department->name . '"')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $department->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Department #{{ $department->id }}
                </p>
            </div>
        </div>
        <a href="{{ route('departments.edit', $department->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Department
        </a>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            {{-- Department Overview --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Department Details --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="space-y-6">
                                {{-- Department Header --}}
                                <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                                    <div class="w-16 h-16 bg-emerald-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900">{{ $department->name }}</h3>
                                        <p class="text-gray-500">Organizational Department</p>
                                    </div>
                                </div>

                                {{-- Department Description --}}
                                <div>
                                    <div class="flex items-center space-x-2 mb-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <h4 class="text-lg font-semibold text-gray-900">Description</h4>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed">
                                        {{ $department->description ?? 'No description provided for this department.' }}
                                    </p>
                                </div>

                                {{-- Department Statistics --}}
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Department Statistics</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="bg-blue-50 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-blue-600">Staff Members</p>
                                                    <p class="text-2xl font-bold text-blue-900">{{ $department->staff_count ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-green-50 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-green-600">Active Projects</p>
                                                    <p class="text-2xl font-bold text-green-900">{{ $department->projects_count ?? 0 }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-purple-50 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <div class="ml-4">
                                                    <p class="text-sm font-medium text-purple-600">Status</p>
                                                    <p class="text-lg font-bold text-purple-900">{{ $department->status ?? 'Active' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Department Details Sidebar --}}
                <div class="space-y-6">
                    {{-- Department Info --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Department Information</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Created By</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $department->createdBy->name ?? 'Unknown' }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m6-6V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-500">Created Date</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-900">
                                        {{ $department->created_at ? $department->created_at->format('M d, Y') : 'Unknown' }}
                                    </span>
                                </div>

                                @if($department->updatedBy)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-500">Updated By</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ $department->updatedBy->name }}
                                        </span>
                                    </div>
                                @endif

                                @if($department->updated_at && $department->updated_at != $department->created_at)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m6-10v10m6-6V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-500">Last Updated</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">
                                            {{ $department->updated_at->format('M d, Y') }}
                                        </span>
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
                                <a href="{{ route('departments.edit', $department->id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Department
                                </a>
                                <a href="{{ route('departments.index') }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-all">
                                    ← Back to Departments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Department Staff --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Department Staff</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Manage staff members in this department
                            </p>
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $department->staff_count ?? 0 }} staff members
                        </div>
                    </div>
                    
                    {{-- Empty State for Staff --}}
                    @if(($department->staff_count ?? 0) == 0)
                        <div class="text-center py-12">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No staff members yet</h3>
                            <p class="text-gray-500 mb-6">
                                Start building your team by adding staff members to this department.
                            </p>
                            @if(Route::has('staff.create'))
                                <a href="{{ route('staff.create', ['department' => $department->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                                    Add Staff Member
                                </a>
                            @else
                                <button class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                                    Add Staff Member
                                </button>
                            @endif
                        </div>
                    @else
                        {{-- Staff List (if you have staff data) --}}
                        <div class="space-y-4">
                            @if(isset($department->staff) && $department->staff->count() > 0)
                                @foreach($department->staff as $staff)
                                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $staff->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $staff->position ?? 'Staff Member' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $staff->email }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection