@extends('layouts.authenticated')

@section('title', 'Add Evaluation Criteria')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Add Evaluation Criteria</h2>
            <p class="text-sm text-gray-600 mt-1">
                             Add a new criteria to "{{ $evaluation->title }}"
         </p>
     </div>
     <a href="{{ route('evaluation.show', $evaluation) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Template
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ route('evaluations.criteria.store') }}" class="p-6 space-y-8">
            @csrf
            <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">

            <!-- Order Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Order Number *
                    </label>
                    <input 
                        type="number" 
                        id="order_number" 
                        name="order_number" 
                        value="{{ old('order_number', $nextOrder) }}" 
                        min="1" 
                        max="100"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('order_number') border-red-500 @enderror"
                    >
                    @error('order_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        The order this criteria appears in the evaluation form
                    </p>
                </div>

                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                        Weight
                    </label>
                    <input 
                        type="number" 
                        id="weight" 
                        name="weight" 
                        value="{{ old('weight', '1.0') }}" 
                        step="0.1" 
                        min="0" 
                        max="10"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('weight') border-red-500 @enderror"
                    >
                    @error('weight')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Importance weight for this criteria (optional)
                    </p>
                </div>
            </div>

            <!-- Titles -->
            <div class="space-y-6">
                <div>
                    <label for="title_kh" class="block text-sm font-medium text-gray-700 mb-2">
                        Title (Khmer) *
                    </label>
                    <input 
                        type="text" 
                        id="title_kh" 
                        name="title_kh" 
                        value="{{ old('title_kh') }}" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title_kh') border-red-500 @enderror"
                        placeholder="e.g., គុណភាពនៃការងារ"
                    >
                    @error('title_kh')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title_en" class="block text-sm font-medium text-gray-700 mb-2">
                        Title (English) *
                    </label>
                    <input 
                        type="text" 
                        id="title_en" 
                        name="title_en" 
                        value="{{ old('title_en') }}" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('title_en') border-red-500 @enderror"
                        placeholder="e.g., Quality of work"
                    >
                    @error('title_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Descriptions -->
            <div class="space-y-6">
                <div>
                    <label for="description_kh" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (Khmer) *
                    </label>
                    <textarea 
                        id="description_kh" 
                        name="description_kh" 
                        rows="4" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description_kh') border-red-500 @enderror"
                        placeholder="e.g., ភាពឥតខ្ចោះ និងភាពជឿជាក់ក្នុងការងារ"
                    >{{ old('description_kh') }}</textarea>
                    @error('description_kh')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description_en" class="block text-sm font-medium text-gray-700 mb-2">
                        Description (English) *
                    </label>
                    <textarea 
                        id="description_en" 
                        name="description_en" 
                        rows="4" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('description_en') border-red-500 @enderror"
                        placeholder="e.g., Accuracy and consistency of work, attention to details"
                    >{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div>
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active" 
                        value="1" 
                        {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                    >
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (Include this criteria in evaluations)
                    </label>
                </div>
                @error('is_active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Example Preview -->
            <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Preview</h3>
                <div class="border border-gray-300 bg-white">
                    <div class="grid grid-cols-4 sm:grid-cols-5 border-b border-gray-300">
                        <div class="col-span-3 sm:col-span-4 p-3 border-r border-gray-300">
                            <p class="font-semibold text-sm" id="preview-order">1</p>
                            <p class="font-semibold text-sm" id="preview-title-kh">Title in Khmer</p>
                            <p class="text-xs" id="preview-title-en">Title in English</p>
                            <p class="text-xs text-gray-600 mt-1" id="preview-desc-kh">Description in Khmer</p>
                            <p class="text-xs text-gray-500" id="preview-desc-en">Description in English</p>
                        </div>
                        <div class="col-span-1 p-3 flex justify-center items-center">
                            <select class="w-full p-2 border rounded text-sm" disabled>
                                <option>Select (1-5)</option>
                            </select>
                        </div>
                    </div>
                    <div class="p-3">
                        <p class="mb-2 text-sm">យោបល់បន្ថែម និងការឆ្លើយតម/Comments & feedback:</p>
                        <textarea rows="2" class="w-full p-2 border rounded text-sm" placeholder="..." disabled></textarea>
                    </div>
                </div>
            </div>

            <!-- Default Examples -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <h3 class="text-sm font-medium text-blue-800 mb-3">Common Evaluation Criteria Examples</h3>
                <div class="space-y-3 text-sm">
                    <button type="button" onclick="fillExample(1)" class="block w-full text-left p-2 bg-white border border-blue-200 rounded hover:bg-blue-50 transition-colors">
                        <strong>Quality of Work</strong><br>
                        <span class="text-xs text-blue-600">គុណភាពនៃការងារ: ភាពឥតខ្ចោះ និងភាពជឿជាក់ក្នុងការងារ</span>
                    </button>
                    <button type="button" onclick="fillExample(2)" class="block w-full text-left p-2 bg-white border border-blue-200 rounded hover:bg-blue-50 transition-colors">
                        <strong>Team Work & Cooperation</strong><br>
                        <span class="text-xs text-blue-600">ការងារជាក្រុម និង ការសហការណ៍: សមត្ថភាពធ្វើការនិងការសហការណ៍បានល្អជាមួយបុគ្គលិកដទៃ</span>
                    </button>
                    <button type="button" onclick="fillExample(3)" class="block w-full text-left p-2 bg-white border border-blue-200 rounded hover:bg-blue-50 transition-colors">
                        <strong>Communication</strong><br>
                        <span class="text-xs text-blue-600">ការប្រាស្រ័យទាក់ទង: ច្បាស់លាស់ និងប្រសិទ្ធភាពចំពោះការងារទាំងការនិយាយ និងការសរសេរ</span>
                    </button>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('evaluation.show', $evaluation) }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors">
                    Add Criteria
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Live preview update
function updatePreview() {
    document.getElementById('preview-order').textContent = document.getElementById('order_number').value + '.';
    document.getElementById('preview-title-kh').textContent = document.getElementById('title_kh').value || 'Title in Khmer';
    document.getElementById('preview-title-en').textContent = document.getElementById('title_en').value || 'Title in English';
    document.getElementById('preview-desc-kh').textContent = document.getElementById('description_kh').value || 'Description in Khmer';
    document.getElementById('preview-desc-en').textContent = document.getElementById('description_en').value || 'Description in English';
}

// Add event listeners for live preview
document.getElementById('order_number').addEventListener('input', updatePreview);
document.getElementById('title_kh').addEventListener('input', updatePreview);
document.getElementById('title_en').addEventListener('input', updatePreview);
document.getElementById('description_kh').addEventListener('input', updatePreview);
document.getElementById('description_en').addEventListener('input', updatePreview);

// Example fill functions
function fillExample(type) {
    if (type === 1) {
        document.getElementById('title_kh').value = 'គុណភាពនៃការងារ';
        document.getElementById('title_en').value = 'Quality of work';
        document.getElementById('description_kh').value = 'ភាពឥតខ្ចោះ និងភាពជឿជាក់ក្នុងការងារ';
        document.getElementById('description_en').value = 'Accuracy and consistency of work, attention to details';
    } else if (type === 2) {
        document.getElementById('title_kh').value = 'ការងារជាក្រុម និង ការសហការណ៍';
        document.getElementById('title_en').value = 'Team work & Cooperation';
        document.getElementById('description_kh').value = 'សមត្ថភាពធ្វើការនិងការសហការណ៍បានល្អជាមួយបុគ្គលិកដទៃ';
        document.getElementById('description_en').value = 'Ability to work and corporate well with others';
    } else if (type === 3) {
        document.getElementById('title_kh').value = 'ការប្រាស្រ័យទាក់ទង';
        document.getElementById('title_en').value = 'Communication';
        document.getElementById('description_kh').value = 'ច្បាស់លាស់ និងប្រសិទ្ធភាពចំពោះការងារទាំងការនិយាយ និងការសរសេរ (ភាសាខ្មែរនិងអង់គ្លេស)';
        document.getElementById('description_en').value = 'Clarity and effectiveness when speaking, writing & communicate both languages Khmer and English';
    }
    updatePreview();
}

// Initialize preview
updatePreview();
</script>
@endsection 