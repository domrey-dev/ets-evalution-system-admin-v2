{{-- resources/views/components/evaluation-model.blade.php --}}
@props([
    'initialData' => [],
    'searchId' => '',
    'errors' => []
])

<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Search User ID
            </label>
            <input
                type="text"
                name="searchId"
                id="searchId"
                value="{{ old('searchId', $searchId) }}"
                placeholder="Search by ID (press Enter to search immediately)"
                class="w-full border-b border-gray-300 p-2 focus:outline-none"
                autocomplete="off"
                data-search-input
            />
            @if($searchId)
                <p class="text-xs text-gray-500 mt-1">
                    Searching for ID: {{ $searchId }}
                </p>
            @endif
            
            @error('searchId')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Monthly Performance
            </label>
            <input
                type="text"
                name="monthlyPerformance"
                value="{{ old('monthlyPerformance', $initialData['monthlyPerformance'] ?? '') }}"
                placeholder="Staff Performance"
                class="w-full border-b border-gray-300 p-2 focus:outline-none"
            />
            
            @error('monthlyPerformance')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Employee Name
            </label>
            <input
                type="text"
                name="employeeName"
                value="{{ old('employeeName', $initialData['employeeName'] ?? '') }}"
                class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readonly
                disabled
            />
            
            @error('employeeName')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Date of Evaluation
            </label>
            <input
                type="date"
                name="evaluationDate"
                value="{{ old('evaluationDate', $initialData['evaluationDate'] ?? '') }}"
                class="w-full border-b border-gray-300 p-2 focus:outline-none"
            />
            
            @error('evaluationDate')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Job Title
            </label>
            <input
                type="text"
                name="jobTitle"
                value="{{ old('jobTitle', $initialData['jobTitle'] ?? '') }}"
                class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readonly
                disabled
            />
            
            @error('jobTitle')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Department
            </label>
            <input
                type="text"
                name="department"
                value="{{ old('department', $initialData['department'] ?? '') }}"
                class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                readonly
                disabled
            />
            
            @error('department')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- Optional: Add JavaScript for search functionality --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('[data-search-input]');
    let searchTimeout;

    if (searchInput) {
        // Debounced search functionality
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const searchValue = e.target.value;
            
            if (searchValue.length >= 3) {
                searchTimeout = setTimeout(() => {
                    performSearch(searchValue);
                }, 500);
            }
        });

        // Enter key search
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.value) {
                e.preventDefault();
                performSearch(e.target.value);
            }
        });
    }

    function performSearch(searchId) {
        // Option 1: Redirect with search parameter
        window.location.href = `{{ request()->url() }}?search=${encodeURIComponent(searchId)}`;
        
        // Option 2: AJAX search (uncomment if you prefer AJAX)
        /*
        fetch(`{{ route('evaluation.search') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ searchId: searchId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update form fields with returned data
                updateFormFields(data.employee);
            }
        })
        .catch(error => console.error('Search error:', error));
        */
    }

    function updateFormFields(employee) {
        document.querySelector('[name="employeeName"]').value = employee.name || '';
        document.querySelector('[name="jobTitle"]').value = employee.job_title || '';
        document.querySelector('[name="department"]').value = employee.department || '';
    }
});
</script>
@endpush