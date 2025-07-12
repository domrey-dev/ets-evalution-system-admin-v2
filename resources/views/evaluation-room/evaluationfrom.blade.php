{{-- resources/views/components/evaluation-form.blade.php --}}
@props([
    'evaluationType' => null,
    'data' => [],
    'criteria' => [],
    'readOnly' => false,
    'errors' => []
])

<div class="mt-6">
    <div class="flex justify-between mb-4">
        <div class="text-sm font-medium">
            <div>តម្លៃសមិទ្ធផល: អ្នកគ្រប់គ្រងផ្ទាល់ផ្តល់យោបល់ខាងក្រោម</div>
            <div class="text-gray-600">Section 2: Evaluation points in practice Comments and feedback by Supervisor/Manager</div>
        </div>
        <div class="text-sm font-medium text-right">
            <div>តម្លៃលេខ ១-៥</div>
            <div class="text-gray-600">Performance Rating 1-5</div>
        </div>
    </div>

    @foreach($criteria as $item)
        <div class="mb-8">
            <div class="mb-2 font-medium">{{ $item['title'] ?? $item->title ?? '' }}</div>
            <div class="text-sm mb-1">យោបល់/Comments & feedback:</div>
            <div class="flex gap-4">
                <div class="flex-grow">
                    <textarea
                        name="feedback[{{ $item['id'] ?? $item->id ?? $loop->index }}]"
                        class="w-full border border-gray-300 rounded p-2 {{ $readOnly ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        rows="2"
                        placeholder="{{ $readOnly ? '' : 'Write feedback here...' }}"
                        {{ $readOnly ? 'readonly' : '' }}
                    >{{ old('feedback.' . ($item['id'] ?? $item->id ?? $loop->index), $data[$item['id'] ?? $item->id ?? $loop->index]['feedback'] ?? '') }}</textarea>
                    
                    @error('feedback.' . ($item['id'] ?? $item->id ?? $loop->index))
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="w-32">
                    <select
                        name="rating[{{ $item['id'] ?? $item->id ?? $loop->index }}]"
                        class="w-full border border-gray-300 rounded p-2 text-sm h-10 {{ $readOnly ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                        {{ $readOnly ? 'disabled' : '' }}
                    >
                        <option value="">Select</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" 
                                {{ old('rating.' . ($item['id'] ?? $item->id ?? $loop->index), $data[$item['id'] ?? $item->id ?? $loop->index]['rating'] ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    
                    @error('rating.' . ($item['id'] ?? $item->id ?? $loop->index))
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    @endforeach
</div>