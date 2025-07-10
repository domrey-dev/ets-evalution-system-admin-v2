{{-- Task Status Constants (you can put these in a config file or helper) --}}
@php
    $taskStatusClassMap = [
        'pending' => 'bg-amber-500',
        'in_progress' => 'bg-blue-500',
        'completed' => 'bg-green-500',
    ];
    
    $taskStatusTextMap = [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
    ];
@endphp

{{-- Success Message --}}
@if(session('success'))
    <div class="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="overflow-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        {{-- Table Headers with Sorting --}}
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
            <tr class="text-nowrap">
                {{-- ID Column --}}
                <th class="px-3 py-3">
                    <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'id', 'sort_direction' => request('sort_field') === 'id' && request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                       class="flex items-center justify-between text-nowrap">
                        ID
                        @if(request('sort_field') === 'id')
                            @if(request('sort_direction') === 'asc')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </th>
                
                {{-- Image Column --}}
                <th class="px-3 py-3">Image</th>
                
                {{-- Project Name Column (conditional) --}}
                @if(!($hideProjectColumn ?? false))
                    <th class="px-3 py-3">Project Name</th>
                @endif
                
                {{-- Name Column --}}
                <th class="px-3 py-3">
                    <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'name', 'sort_direction' => request('sort_field') === 'name' && request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                       class="flex items-center justify-between text-nowrap">
                        Name
                        @if(request('sort_field') === 'name')
                            @if(request('sort_direction') === 'asc')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </th>
                
                {{-- Status Column --}}
                <th class="px-3 py-3">
                    <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'status', 'sort_direction' => request('sort_field') === 'status' && request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                       class="flex items-center justify-between text-nowrap">
                        Status
                        @if(request('sort_field') === 'status')
                            @if(request('sort_direction') === 'asc')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </th>
                
                {{-- Created Date Column --}}
                <th class="px-3 py-3">
                    <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'created_at', 'sort_direction' => request('sort_field') === 'created_at' && request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                       class="flex items-center justify-between text-nowrap">
                        Create Date
                        @if(request('sort_field') === 'created_at')
                            @if(request('sort_direction') === 'asc')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </th>
                
                {{-- Due Date Column --}}
                <th class="px-3 py-3">
                    <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'due_date', 'sort_direction' => request('sort_field') === 'due_date' && request('sort_direction') === 'asc' ? 'desc' : 'asc']) }}" 
                       class="flex items-center justify-between text-nowrap">
                        Due Date
                        @if(request('sort_field') === 'due_date')
                            @if(request('sort_direction') === 'asc')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </a>
                </th>
                
                <th class="px-3 py-3">Created By</th>
                <th class="px-3 py-3 text-right">Actions</th>
            </tr>
        </thead>
        
        {{-- Filter Row --}}
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
            <tr class="text-nowrap">
                <th class="px-3 py-3"></th>
                <th class="px-3 py-3"></th>
                @if(!($hideProjectColumn ?? false))
                    <th class="px-3 py-3"></th>
                @endif
                
                {{-- Name Filter --}}
                <th class="px-3 py-3">
                    <input type="text" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                           placeholder="Task Name"
                           value="{{ request('name') }}"
                           onchange="filterTasks()"
                           id="name-filter">
                </th>
                
                {{-- Status Filter --}}
                <th class="px-3 py-3">
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            onchange="filterTasks()"
                            id="status-filter">
                        <option value="">Select Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </th>
                
                <th class="px-3 py-3"></th>
                <th class="px-3 py-3"></th>
                <th class="px-3 py-3"></th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>
        
        {{-- Table Body --}}
        <tbody>
            @forelse($tasks as $task)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-3 py-2">{{ $task->id }}</td>
                    <td class="px-3 py-2">
                        @if($task->image_path)
                            <img src="{{ $task->image_path }}" style="width: 60px" alt="Task Image" class="rounded">
                        @else
                            <div class="w-15 h-10 bg-gray-200 rounded flex items-center justify-center">
                                <span class="text-xs text-gray-500">No Image</span>
                            </div>
                        @endif
                    </td>
                    @if(!($hideProjectColumn ?? false))
                        <td class="px-3 py-2">{{ $task->project->name ?? 'N/A' }}</td>
                    @endif
                    <th class="px-3 py-2 text-gray-100 hover:underline">
                        <a href="{{ route('task.show', $task->id) }}">{{ $task->name }}</a>
                    </th>
                    <td class="px-3 py-2">
                        <span class="px-2 py-1 rounded text-nowrap text-white {{ $taskStatusClassMap[$task->status] ?? 'bg-gray-500' }}">
                            {{ $taskStatusTextMap[$task->status] ?? ucfirst($task->status) }}
                        </span>
                    </td>
                    <td class="px-3 py-2 text-nowrap">{{ $task->created_at->format('M d, Y') }}</td>
                    <td class="px-3 py-2 text-nowrap">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}</td>
                    <td class="px-3 py-2">{{ $task->createdBy->name ?? 'Unknown' }}</td>
                    <td class="px-3 py-2 text-nowrap">
                        <a href="{{ route('task.edit', $task->id) }}" 
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('task.destroy', $task->id) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ ($hideProjectColumn ?? false) ? '8' : '9' }}" class="px-3 py-8 text-center text-gray-500">
                        No tasks found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($tasks instanceof \Illuminate\Pagination\LengthAwarePaginator && $tasks->hasPages())
    <div class="mt-6">
        {{ $tasks->appends(request()->query())->links() }}
    </div>
@endif

{{-- JavaScript for Filtering --}}
<script>
    function filterTasks() {
        const name = document.getElementById('name-filter').value;
        const status = document.getElementById('status-filter').value;
        
        // Build query parameters
        const params = new URLSearchParams(window.location.search);
        
        // Update or remove parameters
        if (name) {
            params.set('name', name);
        } else {
            params.delete('name');
        }
        
        if (status) {
            params.set('status', status);
        } else {
            params.delete('status');
        }
        
        // Preserve current sort parameters
        const sortField = params.get('sort_field');
        const sortDirection = params.get('sort_direction');
        
        // Navigate to filtered URL
        window.location.href = `{{ route('task.index') }}?${params.toString()}`;
    }
    
    // Add enter key support for name filter
    document.getElementById('name-filter').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterTasks();
        }
    });
    
    // Add blur event for name filter (like the React version)
    document.getElementById('name-filter').addEventListener('blur', function(e) {
        filterTasks();
    });
</script>