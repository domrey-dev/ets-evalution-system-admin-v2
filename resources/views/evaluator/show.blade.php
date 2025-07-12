{{-- resources/views/users/show.blade.php --}}
@extends('layouts.authenticated')

@section('title', 'User - ' . $user->name)

@php
// Helper functions for the view
$userInitials = collect(explode(' ', $user->name))
    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
    ->take(2)
    ->implode('');

$avatarColors = [
    'bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500',
    'bg-indigo-500', 'bg-yellow-500', 'bg-red-500', 'bg-gray-500'
];
$avatarColor = $avatarColors[$user->id % count($avatarColors)];

$contractColors = [
    'Permanent' => 'bg-green-100 text-green-800',
    'Project-based' => 'bg-blue-100 text-blue-800',
    'Internship' => 'bg-yellow-100 text-yellow-800',
    'Subcontract' => 'bg-purple-100 text-purple-800'
];
$contractColor = $contractColors[$user->work_contract] ?? 'bg-gray-100 text-gray-800';
@endphp

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
    <div class="flex items-center space-x-4">
        <a href="{{ route('evaluator.index') }}" 
           class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">User Profile</h2>
            <p class="text-sm text-gray-600 mt-1">View user details and information</p>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        @can('update', $user)
            <a href="{{ route('users.edit', $user->id) }}"
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
        @endcan
    </div>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- User Profile Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 sticky top-8">
                    <div class="p-6">
                        <div class="text-center">
                            {{-- Avatar --}}
                            <div class="mx-auto mb-4">
                                <div class="w-24 h-24 rounded-full flex items-center justify-center text-white font-bold text-2xl {{ $avatarColor }}">
                                    {{ $userInitials }}
                                </div>
                            </div>

                            {{-- User Name and Status --}}
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $user->name }}</h3>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-green-700">Active User</span>
                            </div>

                            {{-- Contact Information --}}
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-center space-x-2 text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm">{{ $user->email }}</span>
                                </div>
                                @if($user->phone)
                                    <div class="flex items-center justify-center space-x-2 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span class="text-sm">{{ $user->phone }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Contract Status --}}
                            @if($user->work_contract)
                                <div class="mb-6">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $contractColor }}">
                                        {{ $user->work_contract }}
                                    </span>
                                </div>
                            @endif

                            {{-- User ID and Join Date --}}
                            <div class="pt-4 border-t border-gray-200 space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">User ID:</span>
                                    <span class="font-medium text-gray-900">#{{ $user->id }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Joined:</span>
                                    <span class="font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Personal Information --}}
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                                    <p class="text-sm text-gray-600">Basic user details and contact information</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Full Name</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email Address</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->email }}</p>
                            </div>
                            @if($user->phone)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Phone Number</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->phone }}</p>
                                </div>
                            @endif
                            @if($user->gender)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Gender</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->gender }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Work Information --}}
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Work Information</h3>
                                    <p class="text-sm text-gray-600">Professional details and work assignment</p>
                                </div>
                            </div>
                        </div>

                        @php
                        $hasWorkInfo = $user->department || $user->position || $user->role || $user->project;
                        @endphp

                        @if($hasWorkInfo)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($user->department)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span>Department</span>
                                        </label>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->department }}</p>
                                    </div>
                                @endif
                                
                                @if($user->position)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                            </svg>
                                            <span>Position</span>
                                        </label>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->position }}</p>
                                    </div>
                                @endif
                                
                                @if($user->role)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                            <span>System Role</span>
                                        </label>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->role }}</p>
                                    </div>
                                @endif
                                
                                @if($user->work_contract)
                                    <div>
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Work Contract</label>
                                        <div class="mt-1">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $contractColor }}">
                                                {{ $user->work_contract }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($user->project)
                                    <div class="md:col-span-2">
                                        <label class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span>Project Assignment</span>
                                        </label>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->project }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- Empty State for Work Information --}}
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No work information</h3>
                                <p class="mt-1 text-sm text-gray-500">Work details have not been assigned yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Account Information --}}
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                                    <p class="text-sm text-gray-600">System access and account details</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Account Status</label>
                                <div class="mt-1 flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-lg font-medium text-green-700">Active</span>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">User ID</label>
                                <p class="mt-1 text-lg font-medium text-gray-900">#{{ $user->id }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 uppercase tracking-wide flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-7m-6 7h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Account Created</span>
                                </label>
                                <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            @if($user->email_verified_at)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email Verified</label>
                                    <p class="mt-1 text-lg font-medium text-gray-900">{{ $user->email_verified_at->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="border-b border-gray-200 pb-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            <p class="text-sm text-gray-600">Common actions for this user</p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @can('update', $user)
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit Profile
                                </a>
                            @endcan
                            
                            @can('viewAny', App\Models\User::class)
                                <a href="{{ route('evaluator.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    View All Users
                                </a>
                            @endcan

                            @if($user->email && auth()->user()->can('sendEmail', $user))
                                <a href="mailto:{{ $user->email }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-200 transition-all">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Send Email
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection