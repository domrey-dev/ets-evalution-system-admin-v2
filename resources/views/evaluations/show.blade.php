@extends('layouts.authenticated')

@section('title', 'Evaluation Template Details')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">{{ $evaluation->title }}</h2>
            <p class="text-sm text-gray-600 mt-1">
                Manage evaluation criteria and preview the form
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('evaluation.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Templates
            </a>
            <a href="{{ route('evaluation.edit', $evaluation) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Template
            </a>
        </div>
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

        {{-- Template Information --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Template Information</h3>
                <div class="mt-2">
                    <p class="text-lg font-semibold text-gray-900">{{ $evaluation->title }}</p>
                    <p class="text-sm text-gray-600">Created by {{ $evaluation->createdBy->name }}</p>
                    <p class="text-xs text-gray-500">{{ $evaluation->created_at->format('M d, Y g:i A') }}</p>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500">Statistics</h3>
                <div class="mt-2">
                    <div class="flex items-center space-x-2">
                        <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $evaluation->criteria->count() }}</p>
                            <p class="text-sm text-gray-500">Total Criteria</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-3">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('evaluation-room.index', ['evaluation_id' => $evaluation->id]) }}" 
                       class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span>Use in Evaluation Room</span>
                    </a>
                    <button onclick="previewEvaluation()" 
                            class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>Preview Form</span>
                    </button>
                </div>
            </div>
            </div>
        </div>

        {{-- Evaluation Criteria --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Evaluation Criteria</h3>
                <p class="text-sm text-gray-600">Manage the questions and rating criteria for this evaluation</p>
            </div>
            <a href="{{ route('evaluations.criteria.create', $evaluation) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Criteria
            </a>
        </div>

        @if($evaluation->criteria->count() > 0)
            <div id="criteria-list">
                @foreach($evaluation->criteria as $criteria)
                    <div class="border-b border-gray-200 p-6 criteria-item" data-id="{{ $criteria->id }}" data-order="{{ $criteria->order_number }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-medium text-gray-600">
                                        {{ $criteria->order_number }}
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-medium text-gray-900">{{ $criteria->title_kh }}</h4>
                                        <p class="text-sm text-gray-600">{{ $criteria->title_en }}</p>
                                    </div>
                                    @if($criteria->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">Khmer Description:</p>
                                        <p class="text-sm text-gray-600">{{ Str::limit($criteria->description_kh, 150) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-1">English Description:</p>
                                        <p class="text-sm text-gray-600">{{ Str::limit($criteria->description_en, 150) }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex items-center space-x-4 text-xs text-gray-500">
                                    <span>Weight: {{ $criteria->weight }}</span>
                                    <span>•</span>
                                    <span>Updated {{ $criteria->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="ml-6 flex items-center space-x-1">
                                <a href="{{ route('evaluations.criteria.edit', [$evaluation, $criteria]) }}" 
                                   class="text-emerald-600 hover:text-emerald-900 transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <button onclick="confirmDeleteCriteria({{ $evaluation->id }}, {{ $criteria->id }})" 
                                        class="text-red-600 hover:text-red-900 transition-colors"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No criteria added</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding your first evaluation criteria.</p>
                <div class="mt-6">
                    <a href="{{ route('evaluations.criteria.create', $evaluation) }}" 
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add First Criteria
                    </a>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>

<!-- Delete Criteria Confirmation Modal -->
<div id="deleteCriteriaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Criteria</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this criteria? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteCriteriaModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </button>
                <form id="deleteCriteriaForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-10 mx-auto p-5 border max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Evaluation Form Preview</h3>
            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="previewContent" class="max-h-96 overflow-y-auto">
            <!-- Preview content will be loaded here -->
        </div>
    </div>
</div>

<script>
function confirmDeleteCriteria(evaluationId, criteriaId) {
    document.getElementById('deleteCriteriaForm').action = `/evaluation/${evaluationId}/criteria/${criteriaId}`;
    document.getElementById('deleteCriteriaModal').classList.remove('hidden');
}

function closeDeleteCriteriaModal() {
    document.getElementById('deleteCriteriaModal').classList.add('hidden');
}

function previewEvaluation() {
    // Load the evaluation form preview
    const content = `
        <div class="space-y-6">
            @foreach($evaluation->criteria as $criteria)
                <div class="border border-gray-300">
                    <div class="grid grid-cols-4 sm:grid-cols-5 border-b border-gray-300">
                        <div class="col-span-3 sm:col-span-4 p-3 border-r border-gray-300">
                            <p class="font-semibold text-sm">{{ $criteria->order_number }}. {{ $criteria->title_kh }}</p>
                            <p class="text-xs">{{ $criteria->title_en }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $criteria->description_kh }}</p>
                            <p class="text-xs text-gray-500">{{ $criteria->description_en }}</p>
                        </div>
                        <div class="col-span-1 p-3 flex justify-center items-center">
                            <select class="w-full p-2 border rounded text-sm" disabled>
                                <option>Select (1-5)</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="mb-2 text-sm">Comments & feedback:</p>
                        <textarea rows="2" class="w-full p-2 border rounded text-sm" placeholder="..." disabled></textarea>
                    </div>
                </div>
            @endforeach
        </div>
    `;
    
    document.getElementById('previewContent').innerHTML = content;
    document.getElementById('previewModal').classList.remove('hidden');
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}

// Close modals when clicking outside
document.getElementById('deleteCriteriaModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteCriteriaModal();
});

document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) closePreviewModal();
});
</script>
@endsection 