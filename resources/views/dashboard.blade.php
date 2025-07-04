{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')
    
@section('title', 'Dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </div>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="relative">
            <div class="p-4 sm:p-6">
                <div class="bg-gray-50 rounded-lg p-4 sm:p-6">
                    <form method="GET" action="{{ route('dashboard') }}" id="filterForm">
                        <div class="space-y-4">
                            <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                                <div class="flex-1">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Time Period
                                            </label>
                                            <select name="month" 
                                                    class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                    onchange="toggleCustomDates()">
                                                @foreach($monthOptions ?? [] as $option)
                                                    <option value="{{ $option['value'] }}" 
                                                            {{ request('month') == $option['value'] ? 'selected' : '' }}>
                                                        {{ $option['label'] }}
                                                    </option>
                                                @endforeach
                                                <option value="custom" {{ request('month') == 'custom' ? 'selected' : '' }}>
                                                    Custom
                                                </option>
                                            </select>
                                        </div>
                                        <div class="min-w-0">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Project
                                            </label>
                                            <select name="project" 
                                                    class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                <option value="">All Projects</option>
                                                @foreach($projects ?? [] as $project)
                                                    <option value="{{ $project->id }}" 
                                                            {{ request('project') == $project->id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="min-w-0 sm:col-span-2 lg:col-span-1">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Department
                                            </label>
                                            <select name="department" 
                                                    class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                                <option value="">All Departments</option>
                                                @foreach($departments ?? [] as $dept)
                                                    <option value="{{ $dept['value'] }}" 
                                                            {{ request('department') == $dept['value'] ? 'selected' : '' }}>
                                                        {{ $dept['label'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    {{-- Custom date range section --}}
                                    <div id="customDateRange" 
                                         class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-gradient-to-r from-gray-50 to-blue-50 rounded-lg border border-gray-200 shadow-inner"
                                         style="{{ request('month') != 'custom' ? 'display: none;' : '' }}">
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-gray-700">
                                                From Date
                                            </label>
                                            <input type="date" 
                                                   name="start_date"
                                                   value="{{ request('start_date') }}"
                                                   class="w-full h-10 border-gray-300 rounded-lg shadow-sm px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium text-gray-700">
                                                To Date
                                            </label>
                                            <input type="date" 
                                                   name="end_date"
                                                   value="{{ request('end_date') }}"
                                                   class="w-full h-10 border-gray-300 rounded-lg shadow-sm px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="hidden lg:block w-px bg-gray-300 mx-4 h-16" id="divider"></div>
                                
                                <div class="flex flex-row gap-3 lg:flex-shrink-0 lg:self-center">
                                    <a href="{{ route('dashboard') }}" 
                                       class="px-4 lg:px-6 py-2.5 bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200 inline-block text-center">
                                        Clear
                                    </a>
                                    <button type="submit"
                                            class="px-4 lg:px-6 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white font-medium rounded-md shadow-sm transition-colors duration-200">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Statistics Cards --}}
<div class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-2 sm:gap-4 lg:gap-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 sm:p-4 lg:p-6 text-gray-900">
                <h3 class="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                    Total
                </h3>
                <p class="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                    <span class="mr-1 sm:mr-2">{{ $myPendingTasks }}</span>
                </p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 sm:p-4 lg:p-6 text-gray-900">
                <h3 class="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                    Completed
                </h3>
                <p class="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                    <span class="mr-1 sm:mr-2">{{ $myPendingTasks }}</span>/
                    <span class="ml-1 sm:ml-2">{{ $totalPendingTasks }}</span>
                </p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 sm:p-4 lg:p-6 text-gray-900">
                <h3 class="text-amber-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                    Incompleted
                </h3>
                <p class="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                    <span class="mr-1 sm:mr-2">{{ $myPendingTasks }}</span>/
                    <span class="ml-1 sm:ml-2">{{ $totalPendingTasks }}</span>
                </p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 sm:p-4 lg:p-6 text-gray-900">
                <h3 class="text-blue-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                    New Staff
                </h3>
                <p class="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                    <span class="mr-1 sm:mr-2">{{ $myProgressTasks }}</span>/
                    <span class="ml-1 sm:ml-2">{{ $totalProgressTasks }}</span>
                </p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 sm:p-4 lg:p-6 text-gray-900">
                <h3 class="text-green-500 text-xs sm:text-lg lg:text-2xl font-semibold">
                    Resing Staff
                </h3>
                <p class="text-xs sm:text-lg lg:text-xl mt-1 sm:mt-2 lg:mt-4">
                    <span class="mr-1 sm:mr-2">{{ $myCompletedTasks }}</span>/
                    <span class="ml-1 sm:ml-2">{{ $totalCompletedTasks }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="relative">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row w-full gap-4 p-2 sm:p-4">
                        {{-- Grade Distribution Chart --}}
                        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                            <h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Grade Distribution</h2>
                            <div class="h-48 sm:h-64">
                                <canvas id="gradeChart"></canvas>
                            </div>
                        </div>

                        {{-- Monthly Performance Trends Chart --}}
                        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                            <h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Monthly Performance Trends</h2>
                            <div class="h-48 sm:h-64">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                            <p class="text-center text-gray-500 mt-4">Average Percentage</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Project and Department Performance Charts --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="relative">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row w-full gap-4 p-2 sm:p-4">
                        {{-- Project Performance Chart --}}
                        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                            <h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Project Performance</h2>
                            <div class="h-48 sm:h-64">
                                <canvas id="projectChart"></canvas>
                            </div>
                        </div>

                        {{-- Department Performance Chart --}}
                        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 w-full lg:w-1/2">
                            <h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Department Performance</h2>
                            <div class="h-48 sm:h-64">
                                <canvas id="departmentChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
// Toggle custom date range visibility
function toggleCustomDates() {
    const monthSelect = document.querySelector('select[name="month"]');
    const customDateRange = document.getElementById('customDateRange');
    const divider = document.getElementById('divider');
    
    if (monthSelect.value === 'custom') {
        customDateRange.style.display = 'grid';
        divider.style.height = '8rem';
    } else {
        customDateRange.style.display = 'none';
        divider.style.height = '4rem';
    }
}

// Chart.js implementations
document.addEventListener('DOMContentLoaded', function() {
    // Grade Distribution Pie Chart
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode(array_column($formattedGradeData, 'name')) !!},
            datasets: [{
                data: {!! json_encode(array_column($formattedGradeData, 'value')) !!},
                backgroundColor: {!! json_encode(array_column($formattedGradeData, 'color')) !!}
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Monthly Performance Line Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($monthlyPerformance)) !!},
            datasets: [{
                label: 'Performance',
                data: {!! json_encode(array_values($monthlyPerformance)) !!},
                borderColor: '#0088FE',
                backgroundColor: 'rgba(0, 136, 254, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Project Performance Bar Chart
    const projectCtx = document.getElementById('projectChart').getContext('2d');
    new Chart(projectCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($projectPerformance)) !!},
            datasets: [{
                label: 'Value',
                data: {!! json_encode(array_values($projectPerformance)) !!},
                backgroundColor: '#6B7280'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 1000,
                    ticks: {
                        stepSize: 200
                    }
                }
            }
        }
    });

    // Department Performance Bar Chart
    const departmentCtx = document.getElementById('departmentChart').getContext('2d');
    new Chart(departmentCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($departmentPerformance)) !!},
            datasets: [{
                label: 'Value',
                data: {!! json_encode(array_values($departmentPerformance)) !!},
                backgroundColor: '#6B7280'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 1000,
                    ticks: {
                        stepSize: 200
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection