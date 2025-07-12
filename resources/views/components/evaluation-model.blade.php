{{-- Evaluation Model Component --}}
@props(['initialData' => [], 'searchId' => '', 'errors' => null])

<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Search User ID
            </label>
            <input type="text" 
                   name="searchId"
                   value="{{ old('searchId', $searchId) }}"
                   @keydown.enter="handleSearch($event.target.value)"
                   placeholder="Search by ID (press Enter to search immediately)"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none @error('searchId') border-red-500 @enderror">
            @error('searchId')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            
            <p x-show="$el.previousElementSibling.value" class="text-xs text-gray-500 mt-1">
                Searching for ID: <span x-text="$el.previousElementSibling.value"></span>
            </p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Monthly Performance
            </label>
            <input type="text" 
                   name="monthlyPerformance"
                   value="{{ old('monthlyPerformance', $initialData['monthlyPerformance'] ?? '') }}"
                   placeholder="Staff Performance"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none @error('monthlyPerformance') border-red-500 @enderror">
            @error('monthlyPerformance')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Employee Name
            </label>
            <input type="text" 
                   name="employeeName"
                   value="{{ old('employeeName', $initialData['employeeName'] ?? '') }}"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                   readonly>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Date of Evaluation
            </label>
            <input type="date" 
                   name="evaluationDate"
                   value="{{ old('evaluationDate', $initialData['evaluationDate'] ?? '') }}"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none @error('evaluationDate') border-red-500 @enderror">
            @error('evaluationDate')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Job Title
            </label>
            <input type="text" 
                   name="jobTitle"
                   value="{{ old('jobTitle', $initialData['jobTitle'] ?? '') }}"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                   readonly>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Department
            </label>
            <input type="text" 
                   name="department"
                   value="{{ old('department', $initialData['department'] ?? '') }}"
                   class="w-full border-b border-gray-300 p-2 focus:outline-none bg-gray-100"
                   readonly>
        </div>
    </div>
</div> 