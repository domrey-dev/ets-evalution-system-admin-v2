@extends('layouts.app')

@section('title', 'Users')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Users</h2>
        <p class="text-sm text-gray-600 mt-1">
            Manage system users and their permissions
        </p>
    </div>
         <a href="{{ route('users.create') }}" 
        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
         </svg>
         Add New User
     </a>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search and Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                                         <form method="GET" action="{{ route('evaluator.index') }}" id="filterForm">
                        <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                            <div class="flex-1">
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Name
                                            </label>
                                            <input type="text" 
                                                   name="name"
                                                   value="{{ request('name') }}"
                                                   placeholder="Search by name..."
                                                   class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        </div>
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Phone
                                            </label>
                                            <input type="text" 
                                                   name="phone"
                                                   value="{{ request('phone') }}"
                                                   placeholder="Search by phone..."
                                                   class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        </div>
                                        <div class="min-w-0 sm:col-span-2 lg:col-span-1">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Role
                                            </label>
                                            <input type="text" 
                                                   name="role"
                                                   value="{{ request('role') }}"
                                                   list="roles"
                                                   placeholder="Type or select role..."
                                                   class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                            <datalist id="roles">
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                                <option value="moderator">Moderator</option>
                                                <option value="staff">Staff</option>
                                                <option value="manager">Manager</option>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Work Contract
                                            </label>
                                            <select name="work_contract" 
                                                    class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                <option value="">All Contracts</option>
                                                <option value="full-time" {{ request('work_contract') == 'full-time' ? 'selected' : '' }}>Full Time</option>
                                                <option value="part-time" {{ request('work_contract') == 'part-time' ? 'selected' : '' }}>Part Time</option>
                                                <option value="contract" {{ request('work_contract') == 'contract' ? 'selected' : '' }}>Contract</option>
                                            </select>
                                        </div>
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Gender
                                            </label>
                                            <select name="gender" 
                                                    class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                <option value="">All Genders</option>
                                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hidden lg:block w-px h-32 bg-gray-300 mx-4"></div>
                            
                            <div class="flex flex-row gap-3 lg:flex-shrink-0 lg:self-center">
                                                                 <a href="{{ route('evaluator.index') }}" 
                                    class="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200">
                                    Clear
                                </a>
                                <button type="submit" 
                                        class="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content - Table Only -->
        @if($users->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                                    ID
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                    Phone
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                    Contract
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-24">
                                    Gender
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                    Position
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                    Department
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                    Project
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                                    Role
                                </th>
                                <th class="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-16 sm:w-32">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                        {{ $user->id }}
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-6 w-6 sm:h-8 sm:w-8">
                                                @php
                                                    $initials = collect(explode(' ', $user->name))
                                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                        ->take(2)
                                                        ->join('');
                                                    $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-indigo-500', 'bg-yellow-500', 'bg-red-500', 'bg-gray-500'];
                                                    $color = $colors[$user->id % count($colors)];
                                                @endphp
                                                <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-white font-semibold text-xs {{ $color }}">
                                                    {{ $initials }}
                                                </div>
                                            </div>
                                            <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                                <div class="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 truncate">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        {{ $user->phone ?? '-' }}
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                                        @if($user->work_contract)
                                            @php
                                                $contractColors = [
                                                    'Permanent' => 'bg-green-100 text-green-800',
                                                    'Project-based' => 'bg-blue-100 text-blue-800',
                                                    'Internship' => 'bg-yellow-100 text-yellow-800',
                                                    'Subcontract' => 'bg-purple-100 text-purple-800'
                                                ];
                                                $contractColor = $contractColors[$user->work_contract] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-1 sm:px-2 py-1 rounded-full text-xs font-medium {{ $contractColor }}">
                                                <span class="hidden sm:inline">{{ $user->work_contract }}</span>
                                                <span class="sm:hidden">{{ substr($user->work_contract, 0, 8) }}</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        {{ $user->gender ?? '-' }}
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        <div class="truncate max-w-24 sm:max-w-32">
                                            {{ $user->position ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        <div class="truncate max-w-24 sm:max-w-32">
                                            {{ $user->department ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        <div class="truncate max-w-24 sm:max-w-32">
                                            {{ $user->project ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                        <div class="truncate max-w-16 sm:max-w-32">
                                            {{ $user->role ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-1 sm:space-x-2">
                                                                                         <a href="{{ route('users.edit', $user) }}" 
                                                class="text-emerald-600 hover:text-emerald-900 transition-colors"
                                                title="Edit">
                                                 <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                 </svg>
                                             </a>
                                             <form method="POST" action="{{ route('users.destroy', $user) }}" 
                                                   style="display: inline;"
                                                   onsubmit="return confirm('Are you sure you want to delete &quot;{{ $user->name }}&quot;?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 transition-colors"
                                                        title="Delete">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No users found</h3>
                <p class="text-gray-500 mb-6">
                    @if(request()->hasAny(['name', 'phone', 'role', 'work_contract', 'gender']))
                        No users match your search criteria. Try adjusting your filters.
                    @else
                        Get started by creating your first user.
                    @endif
                </p>
                @if(!request()->hasAny(['name', 'phone', 'role', 'work_contract', 'gender']))
                                         <a href="{{ route('users.create') }}" 
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-all">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                         </svg>
                         Create User
                     </a>
                @endif
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto-submit form on Enter key press
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#filterForm input, #filterForm select');
        inputs.forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('filterForm').submit();
                }
            });
        });
    });
</script>
@endpush
@endsection