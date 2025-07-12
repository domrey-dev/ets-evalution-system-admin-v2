{{-- resources/views/evaluation-room/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Evaluation Room')

@push('styles')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@php
$evaluationTypes = [
    'staff' => 'STAFF',
    'self' => 'SELF', 
    'final' => 'FINAL'
];

// Permission checks
$canAccessRoomStaff = auth()->user()->can('evaluation-room-staff');
$canAccessRoomSelf = auth()->user()->can('evaluation-room-self');
$canAccessRoomFinal = auth()->user()->can('evaluation-room-final');
$canSubmitRoom = auth()->user()->can('evaluation-room-submit');

// Determine default active tab based on permissions
$defaultActiveTab = $canAccessRoomSelf ? 'self' : 
    ($canAccessRoomStaff ? 'staff' : 
    ($canAccessRoomFinal ? 'final' : 'self'));

$showTabs = collect([$canAccessRoomStaff, $canAccessRoomSelf, $canAccessRoomFinal])->filter()->count() > 1;
@endphp

@section('header')
<div class="flex items-center justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Evaluation Room
    </h2>
         @if($canSubmitRoom)
         <a href="{{ route('evaluation-room.create') }}" 
            class="bg-emerald-500 py-2 px-4 text-white rounded shadow hover:bg-emerald-600 transition">
             Submit Evaluation
         </a>
     @endif
</div>
@endsection

@section('content')
<div class="py-12" 
     x-data="evaluationRoom()" 
     x-init="init()"
     @search-employee.window="handleSearch($event.detail)">
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Navigation tabs --}}
                @if($showTabs)
                    <x-evaluation-nav 
                        :activeTab="request('tab', $defaultActiveTab)"
                        baseRoute="evaluation-room" 
                    />
                @endif

                {{-- Tab header --}}
                <div class="mb-6 mt-4 text-center">
                    <h1 class="text-2xl font-bold mb-2" x-text="getActiveTabTitle()"></h1>
                    <p class="text-gray-600" x-text="getActiveTabDescription()"></p>
                </div>

                                 <form method="POST" action="{{ route('evaluation-room.store') }}" @submit.prevent="handleSubmit">
                    @csrf
                    
                                         {{-- Evaluation model selector --}}
                     <x-evaluation-model 
                         :initialData="$model_data ?? []"
                         :searchId="request('employeeId', '')"
                         :errors="$errors" 
                     />

                    {{-- Error message --}}
                    <div x-show="submitError" 
                         class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded"
                         x-text="submitError"
                         style="display: none;">
                    </div>

                    {{-- Hidden fields for form data --}}
                    <input type="hidden" name="evaluation_type" x-model="activeTab">
                    
                    {{-- Staff evaluation form --}}
                    @if($canAccessRoomStaff)
                        <div x-show="activeTab === 'staff'" class="mt-6">
                            <h2 class="text-xl font-semibold mb-4">Staff Evaluation</h2>
                            
                                                         <x-evaluation-form 
                                 :criteria="$criteria ?? []"
                                 :data="$final['staff'] ?? []"
                                 :readOnly="!$canSubmitRoom"
                                 :errors="$errors"
                                 evaluationType="staff"
                             />
                        </div>
                    @endif

                    {{-- Self evaluation form --}}
                    @if($canAccessRoomSelf)
                        <div x-show="activeTab === 'self'" class="mt-6">
                            <h2 class="text-xl font-semibold mb-4">Self Evaluation</h2>
                            
                                                         <x-evaluation-form 
                                 :criteria="$criteria ?? []"
                                 :data="$final['self'] ?? []"
                                 :readOnly="!$canSubmitRoom"
                                 :errors="$errors"
                                 evaluationType="self"
                             />
                        </div>
                    @endif

                    {{-- Final evaluation form --}}
                    @if($canAccessRoomFinal)
                        <div x-show="activeTab === 'final'" class="mt-6">
                            <h2 class="text-xl font-semibold mb-4">Final Evaluation</h2>
                            
                            {{-- Comparison section --}}
                            <div class="flex gap-6 mb-6">
                                                                 @if($canAccessRoomStaff && isset($final['staff']))
                                     <div class="w-1/2 border rounded p-4 bg-gray-50">
                                         <h3 class="font-bold mb-2">Staff Evaluation</h3>
                                         
                                         <x-evaluation-form 
                                             :criteria="$criteria ?? []"
                                             :data="$final['staff'] ?? []"
                                             :readOnly="true"
                                             evaluationType="staff"
                                         />
                                         
                                         <button type="button"
                                                 @click="copyToFinal('staff')"
                                                 class="mt-2 bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600 transition">
                                             Choose this
                                         </button>
                                     </div>
                                 @endif

                                                                 @if($canAccessRoomSelf && isset($final['self']))
                                     <div class="w-1/2 border rounded p-4 bg-gray-50">
                                         <h3 class="font-bold mb-2">Self Evaluation</h3>
                                         
                                         <x-evaluation-form 
                                             :criteria="$criteria ?? []"
                                             :data="$final['self'] ?? []"
                                             :readOnly="true"
                                             evaluationType="self"
                                         />
                                         
                                         <button type="button"
                                                 @click="copyToFinal('self')"
                                                 class="mt-2 bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600 transition">
                                             Choose this
                                         </button>
                                     </div>
                                 @endif
                            </div>

                                                         {{-- Final evaluation form --}}
                             <x-evaluation-form 
                                 :criteria="$criteria ?? []"
                                 :data="$final['final'] ?? []"
                                 :readOnly="!$canSubmitRoom"
                                 :errors="$errors"
                                 evaluationType="final"
                             />
                        </div>
                    @endif

                    {{-- Submit button --}}
                    @if($canSubmitRoom)
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                    class="bg-emerald-500 py-2 px-6 text-white rounded shadow hover:bg-emerald-600 transition disabled:opacity-50"
                                    :disabled="isSubmitting">
                                <span x-show="!isSubmitting">Submit Evaluation</span>
                                <span x-show="isSubmitting">Submitting...</span>
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function evaluationRoom() {
    return {
        activeTab: '{{ request("tab", $defaultActiveTab) }}',
        isSubmitting: false,
        submitError: null,
        evaluationData: @json($modelData ?? []),
        
        // Permission flags
        canAccessRoomStaff: {{ $canAccessRoomStaff ? 'true' : 'false' }},
        canAccessRoomSelf: {{ $canAccessRoomSelf ? 'true' : 'false' }},
        canAccessRoomFinal: {{ $canAccessRoomFinal ? 'true' : 'false' }},
        canSubmitRoom: {{ $canSubmitRoom ? 'true' : 'false' }},

        init() {
            // Initialize based on URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam && ['staff', 'self', 'final'].includes(tabParam)) {
                this.activeTab = tabParam;
            }

            // Listen for tab changes
            this.$watch('activeTab', (newTab) => {
                this.updateURL(newTab);
            });
        },

        updateURL(tab) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        },

        getActiveTabTitle() {
            switch (this.activeTab) {
                case 'staff':
                    return 'Staff Evaluation Room';
                case 'self':
                    return 'Self Evaluation Room';
                case 'final':
                    return 'Final Evaluation Room';
                default:
                    return 'Evaluation Room';
            }
        },

        getActiveTabDescription() {
            switch (this.activeTab) {
                case 'staff':
                    return 'Department Head Evaluation';
                case 'self':
                    return 'Employee Self Evaluation';
                case 'final':
                    return 'Final Review Evaluation';
                default:
                    return '';
            }
        },

                 async handleSearch(employeeId) {
             if (employeeId) {
                 window.location.href = '{{ route('evaluation-room.index') }}?employeeId=' + employeeId;
             }
         },

        

        copyToFinal(sourceType) {
            // Copy values from source evaluation to final evaluation
            const sourceInputs = document.querySelectorAll(`[name^="feedback[${sourceType}]"], [name^="rating[${sourceType}]"]`);
            
            sourceInputs.forEach(input => {
                const finalName = input.name.replace(`[${sourceType}]`, '[final]');
                const finalInput = document.querySelector(`[name="${finalName}"]`);
                if (finalInput) {
                    finalInput.value = input.value;
                }
            });
        },

        async handleSubmit(event) {
            this.isSubmitting = true;
            this.submitError = null;

            try {
                // Let the form submit naturally
                event.target.submit();
            } catch (error) {
                this.submitError = error.message;
                this.isSubmitting = false;
            }
        }
    }
}
</script>
@endpush
@endsection