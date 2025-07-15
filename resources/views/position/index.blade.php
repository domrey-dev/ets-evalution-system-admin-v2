@php use Carbon\Carbon; @endphp
{{-- resources/views/projects/index.blade.php --}}
@extends('layouts.authenticated')

@section('title', 'Staff')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Staff</h2>
            <p class="text-sm text-gray-600 mt-1">
                Manage and track your projects
            </p>
        </div>
        <a href="{{ route('position.create') }}"
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Staff
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

            {{-- Filters and Search --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                        <form method="GET" action="{{ route('position.index') }}"
                              class="flex flex-col lg:flex-row lg:items-end gap-4">
                            <div class="flex-1">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="min-w-0">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Project Name
                                        </label>
                                        <input type="text"
                                               name="name"
                                               value="{{ request('name') }}"
                                               placeholder="Search by name..."
                                               class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    </div>
                                    <div class="min-w-0">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Status
                                        </label>
                                        <select name="status"
                                                class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <option value="">All Status</option>
                                            <option
                                                value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option
                                                value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                                                In Progress
                                            </option>
                                            <option
                                                value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                                Completed
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden lg:block w-px h-16 bg-gray-300 mx-4"></div>

                            <div class="flex flex-row gap-3 lg:flex-shrink-0">
                                <a href="{{ route('position.index') }}"
                                   class="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200 inline-block text-center">
                                    Clear
                                </a>
                                <button type="submit"
                                        class="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200">
                                    Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                                Staff ID
                            </th>
                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Staff Name
                            </th>

                            <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                Created By
                            </th>
                            <th class="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($position as $position )
                            <tr class="hover:bg-gray-50">
                                <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                    {{ $position ->id }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                        {{ $position ->en_name }}
                                    </div>
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $position ->createdBy->name ?? '-' }}
                                </td>
                                <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-1 sm:space-x-2">
                                        <a href="{{ route('position.show', $position ->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors"
                                           title="View">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('staff.edit', $position ->id) }}"
                                           class="text-emerald-600 hover:text-emerald-900 transition-colors"
                                           title="Edit">
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('position.destroy', $position ->id) }}"
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 transition-colors"
                                                    title="Delete">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- Empty State Row --}}
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div
                                        class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
                                    <p class="text-gray-500 mb-6">
                                        Get started by creating your first project.
                                    </p>
                                    <a href="{{ route('position.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Create Project
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
