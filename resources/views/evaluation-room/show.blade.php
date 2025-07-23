@extends('layouts.authenticated')

@section('title', 'View Evaluation')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-8">
        <!-- Header -->
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-2xl font-bold text-gray-900">Evaluation Details</h1>
                <p class="mt-2 text-sm text-gray-700">View evaluation results and feedback</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none flex space-x-3">
                <a href="{{ route('evaluation-room.index') }}" 
                   class="inline-flex items-center justify-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Evaluation Room
                </a>
                @can('evaluation-room-edit')
                <a href="{{ route('evaluation-room.edit', $evaluation) }}" 
                   class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Evaluation
                </a>
                @endcan
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mt-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Evaluation Information -->
        <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Evaluation Information</h3>
            </div>
            <div class="px-6 py-4">
                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Employee</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $evaluation->user->name ?? 'N/A' }}
                            @if($evaluation->user_id)
                                <span class="text-gray-500">(ID: {{ $evaluation->user_id }})</span>
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Evaluation Type</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $evaluation->evaluation_type === 'self' ? 'bg-blue-100 text-blue-800' : 
                                   ($evaluation->evaluation_type === 'staff' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ ucfirst($evaluation->evaluation_type) }} Evaluation
                            </span>
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Evaluation Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($evaluation->evaluation_date)
                                {{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('M j, Y') }}
                            @else
                                Not specified
                            @endif
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Monthly Performance</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->monthly_performance ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->creator->name ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $evaluation->created_at->format('M j, Y \a\t g:i A') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Employee Information -->
        @if($evaluation->user)
        <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Employee Information</h3>
            </div>
            <div class="px-6 py-4">
                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->name }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->email }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Department</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->department->name ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->position->name ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Work Contract</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->work_contract ?? 'N/A' }}</dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $evaluation->user->gender ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        @endif

        <!-- Evaluation Criteria Results -->
        @if($evaluation->childEvaluations && $evaluation->childEvaluations->count() > 0)
        <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Evaluation Results</h3>
                    <div class="text-sm text-gray-600">
                        <div>តម្លៃលេខ ១-៥</div>
                        <div>Performance Rating 1-5</div>
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-600">
                    Section 2: Evaluation points in practice - Comments and feedback by Supervisor/Manager
                </p>
            </div>
            <div class="px-6 py-4 space-y-6">
                @php
                    $totalRatings = 0;
                    $totalCriteria = 0;
                @endphp
                
                @foreach($evaluation->childEvaluations as $childEvaluation)
                    @php
                        if ($childEvaluation->rating) {
                            $totalRatings += $childEvaluation->rating;
                            $totalCriteria++;
                        }
                    @endphp
                    
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">
                                    @if($childEvaluation->evaluation)
                                        {{ $childEvaluation->evaluation->title }}
                                    @else
                                        Evaluation Criteria #{{ $childEvaluation->evaluation_id }}
                                    @endif
                                </h4>
                                
                                @if($childEvaluation->feedback)
                                <div class="mt-3">
                                    <p class="text-sm font-medium text-gray-700">យោបល់/Comments & feedback:</p>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $childEvaluation->feedback }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="ml-6 flex-shrink-0">
                                @if($childEvaluation->rating)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $childEvaluation->rating >= 4 ? 'bg-green-100 text-green-800' : 
                                       ($childEvaluation->rating >= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    Rating: {{ $childEvaluation->rating }}/5
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    No Rating
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Overall Rating Summary -->
                @if($totalCriteria > 0)
                <div class="border-t border-gray-200 pt-4 mt-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-medium text-gray-900">Overall Performance</h4>
                            <p class="text-sm text-gray-600">Average rating across all criteria</p>
                        </div>
                        <div class="text-right">
                            @php
                                $averageRating = $totalRatings / $totalCriteria;
                                $percentage = ($averageRating / 5) * 100;
                            @endphp
                            <div class="text-2xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}/5</div>
                            <div class="text-sm text-gray-600">{{ number_format($percentage, 1) }}%</div>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $averageRating >= 4 ? 'bg-green-100 text-green-800' : 
                                       ($averageRating >= 3 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    @if($averageRating >= 4)
                                        Excellent
                                    @elseif($averageRating >= 3)
                                        Good
                                    @elseif($averageRating >= 2)
                                        Fair
                                    @else
                                        Needs Improvement
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="mt-8 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No evaluation criteria results</h3>
                <p class="mt-1 text-sm text-gray-500">This evaluation doesn't have any detailed criteria results.</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-3">
            @can('evaluation-room-delete')
            <form action="{{ route('evaluation-room.destroy', $evaluation) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Are you sure you want to delete this evaluation? This action cannot be undone.')"
                        class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Evaluation
                </button>
            </form>
            @endcan
            
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Report
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    .print-break { page-break-before: always; }
}
</style>
@endsection 