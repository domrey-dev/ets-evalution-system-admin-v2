@extends('layouts.app')

@section('title', 'Evaluations')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Evaluations</h2>
            <p class="text-sm text-gray-600 mt-1">
                ផ្នែកទី២: ចំណុចវាយតម្លៃ ការអនុវត្តការងារជាក់ស្តែងយោបល់បន្ថែម និងការឆ្លើយតបរបស់ប្រធានសាមី
            </p>
        </div>
        <a href="{{ route('evaluation.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 shadow-sm transition-all duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Evaluation
        </a>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search and Filters --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-gray-50 rounded-lg p-4 sm:p-6 mb-6">
                        <form method="GET" action="{{ route('evaluation.index') }}" class="flex flex-col lg:flex-row lg:items-end gap-4">
                            <div class="flex-1">
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="min-w-0">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Evaluation Name
                                        </label>
                                        <input 
                                            type="text"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Search evaluations..."
                                            class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                        />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hidden lg:block w-px h-16 bg-gray-300 mx-4"></div>
                            
                            <div class="flex flex-row gap-3 lg:flex-shrink-0">
                                <a href="{{ route('evaluation.index') }}" 
                                   class="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200">
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

            {{-- Content --}}
            @if($evaluations && $evaluations->count() > 0)
                {{-- Table View --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12 sm:w-16">
                                        ID
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Evaluation Title
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                        Responses
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                        Created By
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                        Created Date
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24 sm:w-32">
                                        Updated Date
                                    </th>
                                    <th class="px-2 sm:px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-20 sm:w-32">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($evaluations as $evaluation)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                                            {{ $evaluation->id }}
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4">
                                            <div class="text-xs sm:text-sm font-medium text-gray-900 truncate">
                                                {{ $evaluation->title }}
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                <span class="text-xs sm:text-sm text-gray-900">{{ $evaluation->total_responses ?? 0 }}</span>
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            <div class="truncate max-w-24 sm:max-w-32">
                                                {{ $evaluation->createdBy->name ?? 'Unknown' }}
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ $evaluation->created_at ? $evaluation->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                            {{ $evaluation->updated_at ? $evaluation->updated_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-2 sm:px-4 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-1 sm:space-x-2">
                                                <a href="{{ route('evaluation.show', $evaluation->id) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition-colors"
                                                   title="View">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('evaluation.edit', $evaluation->id) }}" 
                                                   class="text-emerald-600 hover:text-emerald-900 transition-colors"
                                                   title="Edit">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form method="POST" action="{{ route('evaluation.destroy', $evaluation->id) }}" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 transition-colors"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete the {{ $evaluation->title }} evaluation?')">
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
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No evaluations found</h3>
                        <p class="text-gray-500 mb-6">
                            @if(request('search'))
                                No evaluations match "{{ request('search') }}". Try adjusting your search.
                            @else
                                Get started by creating your first evaluation form.
                            @endif
                        </p>
                        @if(!request('search'))
                            <a href="{{ route('evaluation.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Evaluation
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Pagination --}}
            @if($evaluations instanceof \Illuminate\Pagination\LengthAwarePaginator && $evaluations->hasPages())
                <div class="mt-6">
                    {{ $evaluations->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection