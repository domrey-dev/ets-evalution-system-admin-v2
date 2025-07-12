{{-- resources/views/components/evaluation-nav.blade.php --}}
@props([
    'activeTab' => 'staff',
    'baseRoute' => 'evaluation'
])

@php
$navItems = [
    ['id' => 'staff', 'label' => 'Staff Evaluation', 'khmerLabel' => 'ការវាយតម្លៃបុគ្គលិក'],
    ['id' => 'self', 'label' => 'Self Evaluation', 'khmerLabel' => 'ការវាយតម្លៃខ្លួនឯង'],
    ['id' => 'final', 'label' => 'Final Evaluation', 'khmerLabel' => 'ការវាយតម្លៃចុងក្រោយ'],
];
@endphp

<div class="mb-6 border-b border-gray-200">
    <div class="flex justify-center overflow-x-auto space-x-4">
        @foreach($navItems as $item)
            <a
                href="{{ route($baseRoute . '.' . $item['id']) }}"
                class="py-3 px-4 focus:outline-none transition-colors duration-200 whitespace-nowrap {{ 
                    $activeTab === $item['id'] 
                        ? 'border-b-2 border-emerald-500 text-emerald-600 font-medium' 
                        : 'text-gray-600 hover:text-gray-800 hover:border-b-2 hover:border-gray-300' 
                }}"
                @if($activeTab === $item['id']) aria-current="page" @endif
            >
                <div class="text-sm font-medium text-center">
                    <div class="mb-1">{{ $item['khmerLabel'] }}</div>
                    <div class="text-xs">{{ $item['label'] }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>

{{-- Alternative version with JavaScript tab switching (for single page) --}}
{{--
<div class="mb-6 border-b border-gray-200" x-data="{ activeTab: '{{ $activeTab }}' }">
    <div class="flex justify-center overflow-x-auto space-x-4">
        @foreach($navItems as $item)
            <button
                @click="activeTab = '{{ $item['id'] }}'; $dispatch('tab-changed', '{{ $item['id'] }}')"
                class="py-3 px-4 focus:outline-none transition-colors duration-200 whitespace-nowrap"
                :class="activeTab === '{{ $item['id'] }}' 
                    ? 'border-b-2 border-emerald-500 text-emerald-600 font-medium' 
                    : 'text-gray-600 hover:text-gray-800 hover:border-b-2 hover:border-gray-300'"
                :aria-current="activeTab === '{{ $item['id'] }}' ? 'page' : null"
            >
                <div class="text-sm font-medium text-center">
                    <div class="mb-1">{{ $item['khmerLabel'] }}</div>
                    <div class="text-xs">{{ $item['label'] }}</div>
                </div>
            </button>
        @endforeach
    </div>
</div>
--}}