{{-- Evaluation Navigation Component --}}
@props(['activeTab' => 'self', 'baseRoute' => 'evaluation-room'])

@php
$canAccessRoomStaff = auth()->user()->can('evaluation-room-staff');
$canAccessRoomSelf = auth()->user()->can('evaluation-room-self');
$canAccessRoomFinal = auth()->user()->can('evaluation-room-final');

$navItems = [
    ['id' => 'staff', 'label' => 'Staff Evaluation', 'khmerLabel' => 'ការវាយតម្លៃបុគ្គលិក', 'canAccess' => $canAccessRoomStaff],
    ['id' => 'self', 'label' => 'Self Evaluation', 'khmerLabel' => 'ការវាយតម្លៃខ្លួនឯង', 'canAccess' => $canAccessRoomSelf],
    ['id' => 'final', 'label' => 'Final Evaluation', 'khmerLabel' => 'ការវាយតម្លៃចុងក្រោយ', 'canAccess' => $canAccessRoomFinal],
];
@endphp

<div class="mb-6 border-b border-gray-200">
    <div class="flex justify-center overflow-x-auto space-x-4">
        @foreach($navItems as $item)
            @if($item['canAccess'])
                <button 
                    @click="activeTab = '{{ $item['id'] }}'"
                    :class="activeTab === '{{ $item['id'] }}' ? 'border-b-2 border-emerald-500 text-emerald-600 font-medium' : 'text-gray-600 hover:text-gray-800 hover:border-b-2 hover:border-gray-300'"
                    class="py-3 px-4 focus:outline-none transition-colors duration-200 whitespace-nowrap">
                    <div class="text-sm font-medium text-center">
                        <div class="mb-1">{{ $item['khmerLabel'] }}</div>
                        <div class="text-xs">{{ $item['label'] }}</div>
                    </div>
                </button>
            @endif
        @endforeach
    </div>
</div> 