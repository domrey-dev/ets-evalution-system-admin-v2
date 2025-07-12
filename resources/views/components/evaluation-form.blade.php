{{-- Evaluation Form Component --}}
@props(['criteria' => [], 'data' => [], 'readOnly' => false, 'errors' => null, 'evaluationType' => 'self'])

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
    
    @if($criteria instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @php $criteriaItems = $criteria->items(); @endphp
    @else
        @php $criteriaItems = $criteria; @endphp
    @endif
    
    @foreach($criteriaItems as $criterion)
        @php
            $criterionId = $criterion->id ?? $criterion['id'] ?? null;
            $criterionTitle = $criterion->title ?? $criterion['title'] ?? '';
            $existingData = $data[$criterionId] ?? [];
            $feedback = $existingData['feedback'] ?? '';
            $rating = $existingData['rating'] ?? '';
        @endphp
        
        <div class="mb-8">
            <div class="mb-2 font-medium">{{ $criterionTitle }}</div>
            <div class="text-sm mb-1">យោបល់/Comments & feedback:</div>
            <div class="flex gap-4">
                <div class="flex-grow">
                    <textarea 
                        name="feedback[{{ $evaluationType }}][{{ $criterionId }}]"
                        rows="2"
                        placeholder="{{ $readOnly ? '' : 'Write feedback here...' }}"
                        class="w-full border border-gray-300 rounded p-2 {{ $readOnly ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('feedback.' . $evaluationType . '.' . $criterionId) border-red-500 @enderror"
                        {{ $readOnly ? 'readonly' : '' }}>{{ old('feedback.' . $evaluationType . '.' . $criterionId, $feedback) }}</textarea>
                    @error('feedback.' . $evaluationType . '.' . $criterionId)
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="w-32">
                    <select 
                        name="rating[{{ $evaluationType }}][{{ $criterionId }}]"
                        class="w-full border border-gray-300 rounded p-2 text-sm h-10 {{ $readOnly ? 'bg-gray-100 cursor-not-allowed' : '' }} @error('rating.' . $evaluationType . '.' . $criterionId) border-red-500 @enderror"
                        {{ $readOnly ? 'disabled' : '' }}>
                        <option value="">Select</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating.' . $evaluationType . '.' . $criterionId, $rating) == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('rating.' . $evaluationType . '.' . $criterionId)
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    @endforeach
</div> 