{{-- resources/views/components/evaluation-card.blade.php --}}
@props(['criteria' => []])

<div class="flex flex-row gap-4">
    <div class="text-sm font-bold mb-4">
        <div class="flex justify-between">
            <div>
                តម្លៃសមិទ្ធផល: អ្នកគ្រប់គ្រងផ្ទាល់ផ្តល់យោបល់ខាងក្រោម<br />
                <span class="font-normal">Section 2: Evaluation points in practice Comments and feedback by Supervisor/Manager</span>
            </div>
            <div>
                តម្លៃលេខ ១-៥<br />
                <span class="font-normal">Performance Rating 1–5</span>
            </div>
        </div>
    </div>

    @foreach($criteria as $item)
        <div class="mb-8">
            <div class="flex justify-between items-start gap-4">
                <div class="w-full">
                    <p class="font-medium mb-1">{{ $item['title'] ?? $item->title ?? '' }}</p>
                    <label class="text-sm block mb-1">
                        យោបល់/Comments & feedback:
                    </label>
                    <textarea
                        name="feedback_{{ $item['id'] ?? $item->id ?? $loop->index }}"
                        class="w-full border border-gray-300 rounded p-2 text-sm"
                        rows="3"
                        placeholder="Write feedback here..."
                    ></textarea>
                </div>
                <div class="w-32">
                    <select 
                        name="rating_{{ $item['id'] ?? $item->id ?? $loop->index }}"
                        class="w-full border border-gray-300 rounded p-2 text-sm"
                    >
                        <option value="">Select</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    @endforeach
</div>