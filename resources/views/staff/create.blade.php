{{-- resources/views/projects/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Staff')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Create Staff</h2>
            <p class="text-sm text-gray-600 mt-1">
                Create a new Staff
            </p>
        </div>
        <a href="{{ route('staff.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
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
            <form method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data" class="divide-y divide-gray-200">
                @csrf

                {{-- Project Details Section --}}
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Create New Staff</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Staff Code --}}
                            <div>
                                <label for="staff_code" class="text-sm font-medium text-gray-700">
                                    Staff Code <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input id="staff_code"
                                           type="text"
                                           name="staff_code"
                                           value="{{ old('staff_code') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('staff_code') border-red-300 @enderror"
                                           placeholder="Enter Staff Code"
                                           required
                                           autofocus />
                                </div>
                                @error('staff_code')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- English Name --}}
                            <div>
                                <label for="en_name" class="text-sm font-medium text-gray-700">
                                    English Name <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input id="en_name"
                                           type="text"
                                           name="en_name"
                                           value="{{ old('en_name') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('en_name') border-red-300 @enderror"
                                           placeholder="Enter English Name"
                                           required />
                                </div>
                                @error('en_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Khmer Name --}}
                            <div>
                                <label for="kh_name" class="text-sm font-medium text-gray-700">
                                    Khmer Name <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input id="kh_name"
                                           type="text"
                                           name="kh_name"
                                           value="{{ old('kh_name') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('kh_name') border-red-300 @enderror"
                                           placeholder="Enter Khmer Name"
                                           required />
                                </div>
                                @error('kh_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="text-sm font-medium text-gray-700">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input id="email"
                                           type="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('email') border-red-300 @enderror"
                                           placeholder="Enter Email Address"
                                           required />
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label for="phone" class="text-sm font-medium text-gray-700">
                                    Phone Number
                                </label>
                                <div class="mt-1 relative">
                                    <input id="phone"
                                           type="text"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('phone') border-red-300 @enderror"
                                           placeholder="Enter Phone Number" />
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Gender --}}
                            <div>
                                <label for="gender" class="text-sm font-medium text-gray-700">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select id="gender"
                                            name="gender"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('gender') border-red-300 @enderror"
                                            required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                                @error('gender')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Work Contract --}}
                            <div>
                                <label for="work_contract" class="text-sm font-medium text-gray-700">
                                    Work Contract <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select id="work_contract"
                                            name="work_contract"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('work_contract') border-red-300 @enderror"
                                            required>
                                        <option value="">Select Contract Type</option>
                                        <option value="Permanent" {{ old('work_contract') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                        <option value="Project-based" {{ old('work_contract') == 'Project-based' ? 'selected' : '' }}>Project-based</option>
                                        <option value="Internship" {{ old('work_contract') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        <option value="Subcontract" {{ old('work_contract') == 'Subcontract' ? 'selected' : '' }}>Subcontract</option>
                                    </select>
                                </div>
                                @error('work_contract')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Start of Work --}}
                            <div>
                                <label for="start_of_work" class="text-sm font-medium text-gray-700">
                                    Start of Work <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input id="start_of_work"
                                           type="date"
                                           name="start_of_work"
                                           value="{{ old('start_of_work') }}"
                                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('start_of_work') border-red-300 @enderror"
                                           required />
                                </div>
                                @error('start_of_work')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Department --}}
                            <div>
                                <label for="department_id" class="text-sm font-medium text-gray-700">
                                    Department <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select id="department_id"
                                            name="department_id"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('department_id') border-red-300 @enderror"
                                            required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Position --}}
                            <div>
                                <label for="position_id" class="text-sm font-medium text-gray-700">
                                    Position <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1">
                                    <select id="position_id"
                                            name="position_id"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('position_id') border-red-300 @enderror"
                                            required>
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('position_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Project --}}
                            <div>
                                <label for="project_id" class="text-sm font-medium text-gray-700">
                                    Project
                                </label>
                                <div class="mt-1">
                                    <select id="project_id"
                                            name="project_id"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('project_id') border-red-300 @enderror">
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('project_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="md:col-span-2">
                                <label for="description" class="text-sm font-medium text-gray-700">
                                    Description
                                </label>
                                <div class="mt-1">
                                    <textarea id="description"
                                              name="description"
                                              rows="4"
                                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('description') border-red-300 @enderror"
                                              placeholder="Enter staff description (optional)">{{ old('description') }}</textarea>
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
                        <a href="{{ route('staff.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Create Staff
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
