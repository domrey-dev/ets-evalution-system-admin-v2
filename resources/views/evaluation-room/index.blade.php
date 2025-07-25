@extends('layouts.authenticated')

@section('title', 'Evaluation Room')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-4">
        <!-- Header with Evaluation Form Selection -->
        <div class="flex justify-between items-start mb-6">
            <div>
            <h1 class="text-xl font-medium text-gray-900">Evaluation Room</h1>
                @if($selectedEvaluation)
                    <p class="text-sm text-gray-600 mt-1">Using: <span class="font-medium text-emerald-600">{{ $selectedEvaluation->title }}</span></p>
                @endif
            </div>
            <div class="flex space-x-3">
                @if($allEvaluations->count() > 1)
                <!-- Evaluation Form Selector -->
                <select onchange="changeEvaluationForm(this.value)" 
                        class="px-3 py-2 border border-gray-300 rounded-md text-sm focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    <option value="">Change Evaluation Form</option>
                    @foreach($allEvaluations as $evaluation)
                        <option value="{{ $evaluation->id }}" {{ $selectedEvaluationId == $evaluation->id ? 'selected' : '' }}>
                            {{ $evaluation->title }}
                        </option>
                    @endforeach
                </select>
                @elseif($allEvaluations->count() === 1 && !$selectedEvaluation)
                <!-- Single evaluation available - auto-select it -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        changeEvaluationForm({{ $allEvaluations->first()->id }});
                    });
                </script>
                @endif
                
            @if($canSubmit)
            <button type="button" 
                    onclick="submitEvaluation()" 
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                Submit Evaluation
            </button>
            @endif
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mt-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mt-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
        @endif



        <!-- Navigation Tabs -->
        @if(($canAccessStaff && $canAccessSelf) || ($canAccessStaff && $canAccessFinal) || ($canAccessSelf && $canAccessFinal))
        <div class="mb-6">
            <div class="flex justify-center space-x-12 border-b border-gray-200">
                @if($canAccessStaff)
                <a href="{{ route('evaluation-room.index', $employeeId ? ['tab' => 'staff', 'employeeId' => $employeeId] : ['tab' => 'staff']) }}"
                   class="pb-3 {{ $activeTab === 'staff' ? 'border-b-2 border-emerald-500' : '' }}">
                    <div class="text-center">
                        <div class="text-sm {{ $activeTab === 'staff' ? 'text-emerald-600 font-medium' : 'text-gray-600' }}">ការវាយតម្លៃបុគ្គលិក</div>
                        <div class="text-xs {{ $activeTab === 'staff' ? 'text-emerald-500' : 'text-gray-500' }}">Staff Evaluation</div>
                    </div>
                </a>
                @endif

                @if($canAccessSelf)
                <a href="{{ route('evaluation-room.index', $employeeId ? ['tab' => 'self', 'employeeId' => $employeeId] : ['tab' => 'self']) }}"
                   class="pb-3 {{ $activeTab === 'self' ? 'border-b-2 border-emerald-500' : '' }}">
                    <div class="text-center">
                        <div class="text-sm {{ $activeTab === 'self' ? 'text-emerald-600 font-medium' : 'text-gray-600' }}">ការវាយតម្លៃខ្លួនឯង</div>
                        <div class="text-xs {{ $activeTab === 'self' ? 'text-emerald-500' : 'text-gray-500' }}">Self Evaluation</div>
                    </div>
                </a>
                @endif

                @if($canAccessFinal)
                <a href="{{ route('evaluation-room.index', $employeeId ? ['tab' => 'final', 'employeeId' => $employeeId] : ['tab' => 'final']) }}"
                   class="pb-3 {{ $activeTab === 'final' ? 'border-b-2 border-emerald-500' : '' }}">
                    <div class="text-center">
                        <div class="text-sm {{ $activeTab === 'final' ? 'text-emerald-600 font-medium' : 'text-gray-600' }}">ការវាយតម្លៃចុងក្រោយ</div>
                        <div class="text-xs {{ $activeTab === 'final' ? 'text-emerald-500' : 'text-gray-500' }}">Final Evaluation</div>
                    </div>
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Tab Header -->
        <div class="text-center mb-6">
            <h2 class="text-lg font-semibold text-gray-900">
                @if($activeTab === 'self')
                    Self Evaluation Room
                @elseif($activeTab === 'staff')
                    Staff Evaluation Room
                @elseif($activeTab === 'final')
                    Final Evaluation Room
                @endif
            </h2>
            <p class="text-sm text-gray-600">
                @if($activeTab === 'self')
                    Employee Self Evaluation
                @elseif($activeTab === 'staff')
                    Department Head Evaluation
                @elseif($activeTab === 'final')
                    Final Review Evaluation
                @endif
            </p>
        </div>

        <!-- Evaluation Form -->
        <form id="evaluationForm" method="POST" action="{{ route('evaluation-room.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="evaluation_type" value="{{ $activeTab }}">
            <input type="hidden" name="model_data[evaluationDate]" value="{{ date('Y-m-d') }}">
            
            <!-- Employee Information -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Search User ID</label>
                        <input type="text" 
                               name="model_data[searchId]" 
                               value="{{ request('employeeId', $employeeId) }}"
                               placeholder="Search by ID (press Enter to search immediately)"
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 focus:border-emerald-500 focus:ring-0 bg-transparent">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Monthly Performance</label>
                        <input type="text" 
                               name="model_data[monthlyPerformance]" 
                               placeholder="Staff Performance"
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 focus:border-emerald-500 focus:ring-0 bg-transparent">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Employee Name</label>
                        <input type="text" 
                               name="model_data[employeeName]" 
                               value="{{ $modelData['employeeName'] ?? '' }}"
                               readonly
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 bg-gray-50 text-gray-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Date of Evaluation</label>
                        <input type="date" 
                               name="model_data[evaluationDate]" 
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 focus:border-emerald-500 focus:ring-0 bg-transparent">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Job Title</label>
                        <input type="text" 
                               name="model_data[jobTitle]" 
                               value="{{ $modelData['jobTitle'] ?? '' }}"
                               readonly
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 bg-gray-50 text-gray-500">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Department</label>
                        <input type="text" 
                               name="model_data[department]" 
                               value="{{ $modelData['department'] ?? '' }}"
                               readonly
                               class="w-full px-3 py-2 border-0 border-b border-gray-300 bg-gray-50 text-gray-500">
                    </div>
                </div>
            </div>

            @if($activeTab === 'final')
                <!-- Final Evaluation Comparison Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Final Evaluation - Comparison Review</h3>
                        <div class="text-right text-sm text-gray-600">
                            <div>តម្លៃលេខ ១-៥</div>
                            <div>Performance Rating 1-5</div>
                        </div>
                    </div>

                    @if($staffEvaluation || $selfEvaluation)
                        <!-- Evaluation Source Selection -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Choose Final Evaluation Approach:</h4>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="evaluation_source" value="staff" class="mr-2" onchange="handleSourceChange('staff')">
                                    <span class="text-sm">Accept Staff Evaluation as Final Result</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="evaluation_source" value="self" class="mr-2" onchange="handleSourceChange('self')">
                                    <span class="text-sm">Accept Self Evaluation as Final Result</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="evaluation_source" value="custom" class="mr-2" onchange="handleSourceChange('custom')" checked>
                                    <span class="text-sm">Write Custom Final Evaluation</span>
                                </label>
                            </div>
                        </div>

                        <!-- Comparison View -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Staff Evaluation -->
                            <div class="border border-blue-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <h5 class="font-medium text-blue-700 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                        ការវាយតម្លៃដោយបុគ្គលិក / Staff Evaluation
                                </h5>
                                    @if($staffEvaluation)
                                        @php
                                            $staffTotalScore = $staffEvaluation->total_score ?? $staffEvaluation->criteriaResponses->sum('rating');
                                            $staffGrade = $staffEvaluation->grade ?? 
                                                ($staffTotalScore >= 46 ? 'A' : 
                                                ($staffTotalScore >= 41 ? 'B' : 
                                                ($staffTotalScore >= 36 ? 'C' : 
                                                ($staffTotalScore >= 31 ? 'D' : 'E'))));
                                        @endphp
                                        <div class="text-right">
                                            <div class="text-xs text-gray-600">ពិន្ទុសរុប / Total Score</div>
                                            <div class="font-semibold text-blue-700">{{ $staffTotalScore }}/{{ $staffEvaluation->criteriaResponses->count() * 5 }}</div>
                                            <div class="text-xs font-medium px-2 py-1 rounded 
                                                {{ $staffGrade === 'A' ? 'bg-green-100 text-green-800' : 
                                                   ($staffGrade === 'B' ? 'bg-blue-100 text-blue-800' : 
                                                   ($staffGrade === 'C' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($staffGrade === 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                                Grade {{ $staffGrade }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($staffEvaluation)
                                    <div class="space-y-3">
                                        @foreach($staffEvaluation->criteriaResponses as $response)
                                            <div class="border-b border-gray-100 pb-2 last:border-b-0">
                                                <div class="font-medium text-sm text-gray-900">
                                                    {{ $response->evaluationCriteria->title_kh ?? 'N/A' }} / {{ $response->evaluationCriteria->title_en ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-600">{{ $response->feedback ?: 'No feedback provided' }}</div>
                                                <div class="text-xs font-medium text-blue-600">Rating: {{ $response->rating }}/5</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No staff evaluation completed yet</p>
                                @endif
                            </div>

                            <!-- Self Evaluation -->
                            <div class="border border-emerald-200 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <h5 class="font-medium text-emerald-700 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                        ការវាយតម្លៃខ្លួនឯង / Self Evaluation
                                </h5>
                                    @if($selfEvaluation)
                                        @php
                                            $selfTotalScore = $selfEvaluation->total_score ?? $selfEvaluation->criteriaResponses->sum('rating');
                                            $selfGrade = $selfEvaluation->grade ?? 
                                                ($selfTotalScore >= 46 ? 'A' : 
                                                ($selfTotalScore >= 41 ? 'B' : 
                                                ($selfTotalScore >= 36 ? 'C' : 
                                                ($selfTotalScore >= 31 ? 'D' : 'E'))));
                                        @endphp
                                        <div class="text-right">
                                            <div class="text-xs text-gray-600">ពិន្ទុសរុប / Total Score</div>
                                            <div class="font-semibold text-emerald-700">{{ $selfTotalScore }}/{{ $selfEvaluation->criteriaResponses->count() * 5 }}</div>
                                            <div class="text-xs font-medium px-2 py-1 rounded 
                                                {{ $selfGrade === 'A' ? 'bg-green-100 text-green-800' : 
                                                   ($selfGrade === 'B' ? 'bg-blue-100 text-blue-800' : 
                                                   ($selfGrade === 'C' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($selfGrade === 'D' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800'))) }}">
                                                Grade {{ $selfGrade }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($selfEvaluation)
                                    <div class="space-y-3">
                                        @foreach($selfEvaluation->criteriaResponses as $response)
                                            <div class="border-b border-gray-100 pb-2 last:border-b-0">
                                                <div class="font-medium text-sm text-gray-900">
                                                    {{ $response->evaluationCriteria->title_kh ?? 'N/A' }} / {{ $response->evaluationCriteria->title_en ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-600">{{ $response->feedback ?: 'No feedback provided' }}</div>
                                                <div class="text-xs font-medium text-emerald-600">Rating: {{ $response->rating }}/5</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">No self evaluation completed yet</p>
                                @endif
                            </div>
                        </div>

                        <!-- Custom Final Evaluation Form -->
                        <div id="custom-evaluation-form" class="border border-gray-200 rounded-lg p-4">
                            <h5 class="font-medium text-gray-900 mb-4">Custom Final Evaluation</h5>
                            @if($selectedEvaluation && $criteria->count() > 0)
                    <!-- Section 1: Performance Ratings Instructions -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-4 mb-4">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">
                                <span class="text-emerald-700">ផ្នែកទី១៖</span> វិធីសាស្រ្តនៃការវាយតម្លៃសមិទ្ធិការងារ/
                                <span class="text-emerald-700">Section 1:</span> Instruction of Performance Evaluation Review
                            </h3>
                            <p class="text-sm text-gray-700 mb-3">
                                សូមពិនិត្យមើលនិងពិភាក្សាអំពីកត្តាខាងក្រោមរបស់បុគ្គលិកក្នុងតំណែងការងាររបស់ខ្លួន<br>
                                <span class="italic">Carefully evaluate and discuss the following factors of employee in their position</span>
                            </p>
                        </div>
                        
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3 text-center">Performance ratings</h4>
                            <div class="space-y-2 text-xs">
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៥- ឆ្នើមល្អ<br><span class="text-blue-600">5 - Excellent</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        លើសពីស្តង់ដារនៃការអនុវត្តការងារ និងបង្ហាញសមិទ្ធផលល្អជាង ៩០% នៃអ្នកដែលធ្វើការងារស្រដៀងគ្នា<br>
                                        <span class="italic">Exceed standard job requirements and performs better than 90% of peers</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៤- ល្អ<br><span class="text-blue-600">4 - Outstanding</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        ជាទូទៅលើសពីស្តង់ដារនៃការអនុវត្តការងារ និងបង្ហាញសមិទ្ធផលល្អជាង ៨០% នៃអ្នកដែលធ្វើការងារស្រដៀងគ្នា<br>
                                        <span class="italic">Often exceeds standard job requirements and performs better than 80% of peers</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៣- ប្រកបដោយប្រសិទ្ធភាព<br><span class="text-blue-600">3 - Effective</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        បំពេញតាមតម្រូវការការងារបានត្រឹមត្រូវ<br>
                                        <span class="italic">Meets job requirements</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">២-មិនឆ្លៀត<br><span class="text-blue-600">2 - Inconsistent</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        ធ្វើបានបាន តែមិនបានគ្រប់កម្រិតតាមតម្រូវការការងារទាំងអស់<br>
                                        <span class="italic">Meets some jobs but not all job requirements</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2">
                                    <div class="font-medium text-gray-700">១-មិនសោះ<br><span class="text-blue-600">1 - Unsatisfactory</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        មិនអាចធ្វើតាមការណែនាំរបស់ពេលកាលានុវត្តន៍បានត្រឹមត្រូវ (ស្ថិតនៅពីក្រោយពួកដៃគូការងារ)<br>
                                        <span class="italic">Expectation is not able to follow supervisor instructions effective (far behind peer performance)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                                <!-- Section 2: Final Evaluation Criteria -->
                                 <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                                     <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-3 mb-4">
                                         <div class="flex justify-between items-center">
                                             <div class="flex-1">
                                                 <div class="text-sm font-medium text-gray-800">
                                                     <span class="text-emerald-700">ផ្នែកទី២:</span> ចំណុចបញ្ជាក់ ការអនុវត្តការងារក្នុងស្ថានភាពជាក់ស្តែង និងការផ្តល់យោបល់របស់ថ្នាក់លើ (Final Evaluation)
                                                 </div>
                                                 <div class="text-sm text-gray-600 italic">
                                                     <span class="text-emerald-700">Section 2:</span> Evaluation points in practice Comments and feedback by Supervisor/Manager - {{ $selectedEvaluation->title }}
                                                 </div>
                                             </div>
                                             <div class="text-right text-sm font-medium text-gray-700 border-l border-gray-300 pl-3 ml-3">
                                                 <div>កិច្ចប្រតិបត្តិ ១-៥</div>
                                                 <div>Performance Rating 1-5</div>
                                             </div>
                                         </div>
                                     </div>
                                    
                                @foreach($criteria as $index => $criterion)
                                <div class="mb-6 pb-4 border-b border-gray-100 last:border-b-0">
                                        <div class="mb-3">
                                            <div class="flex items-start space-x-3">
                                                <span class="flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 text-sm font-medium rounded-full mt-0.5">
                                                    {{ $criterion->order_number }}
                                                </span>
                                                <div class="flex-1">
                                                    <h5 class="font-medium text-gray-900">{{ $criterion->title_kh }}</h5>
                                                    <p class="text-sm text-gray-600">{{ $criterion->title_en }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="flex gap-4">
                                        <div class="flex-1">
                                            <label class="text-sm text-gray-600 block mb-1">Final Comments & Feedback:</label>
                                            <textarea name="evaluation[child_evaluations][{{ $index }}][feedback]" 
                                                      rows="2"
                                                      placeholder="Write final evaluation feedback here..."
                                                      class="final-feedback w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-none"></textarea>
                                        </div>
                                        <div class="w-24">
                                            <label class="text-sm text-gray-600 block mb-1">Final Rating</label>
                                            <select name="evaluation[child_evaluations][{{ $index }}][rating]" 
                                                    required
                                                    class="final-rating w-full px-2 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                                <option value="">Select</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" name="evaluation[child_evaluations][{{ $index }}][evaluation_id]" value="{{ $criterion->id }}">
                                </div>
                                @endforeach
                                </div>

                                <!-- Section 3: Summary for Final Evaluation -->
                                <div class="bg-white rounded-lg border border-gray-200 p-6">
                                    <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-4 mb-6">
                                        <h3 class="text-sm font-semibold text-gray-800">
                                            <span class="text-emerald-700">ផ្នែកទី៣៖</span> សង្ខេបយោបល់ និងកំណត់ហេតុ/
                                            <span class="text-emerald-700">Section 3:</span> Summary comments and feedback
                                        </h3>
                                    </div>

                                    <!-- Improvement Points & Suggestions -->
                                    <div class="mb-6">
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3">
                                                ចំណុចកែលម្អ និងការផ្តល់យោបល់ / Improvement Points & Suggestions
                                            </h4>
                                            <textarea name="summary[improvement_points]" 
                                                      rows="4"
                                                      placeholder="Write improvement suggestions and feedback here..."
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-none"></textarea>
                                        </div>
                                    </div>

                                    <!-- Overall Performance Rating -->
                                    <div class="mb-6">
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-4 text-center">
                                                តម្លៃសុិទ្ធនៃសមិទ្ធភាពការងារ / Overall performance rating
                                            </h4>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <!-- Total Score -->
                                                <div class="text-center">
                                                    <div class="bg-white border-2 border-gray-300 rounded-lg p-4">
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            ពិន្ទុសរុប / Total scores
                                                        </label>
                                                        <div class="flex items-center justify-center space-x-2">
                                                            <input type="number" 
                                                                   id="totalScoreInput"
                                                                   name="summary[total_score]" 
                                                                   min="0" 
                                                                   max="50"
                                                                   placeholder="0"
                                                                   readonly
                                                                   class="w-20 text-center text-lg font-semibold border border-gray-300 rounded-md bg-gray-100 text-gray-700">
                                                            <span class="text-lg font-medium text-gray-600">/ 50 scores</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Grade Selection -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        ចំណាត់ថ្នាក់ / ថ្នាក់
                                                    </label>
                                                    <div class="space-y-2 text-xs">
                                                        <label class="flex items-center">
                                                            <input type="radio" id="gradeA" name="summary[grade]" value="A" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                            <span class="font-medium">A: 46 – 50</span>
                                                            <span class="ml-auto text-gray-600">(ឆ្នើមល្អ - Best)</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" id="gradeB" name="summary[grade]" value="B" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                            <span class="font-medium">B: 41 – 45</span>
                                                            <span class="ml-auto text-gray-600">(ល្អ - Good)</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" id="gradeC" name="summary[grade]" value="C" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                            <span class="font-medium">C: 36 – 40</span>
                                                            <span class="ml-auto text-gray-600">(ទទួលយកបាន - Acceptable)</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" id="gradeD" name="summary[grade]" value="D" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                            <span class="font-medium">D: 31 – 35</span>
                                                            <span class="ml-auto text-gray-600">(ត្រូវកែតម្រូវ - Considering)</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" id="gradeE" name="summary[grade]" value="E" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                            <span class="font-medium">E: 26 – 30</span>
                                                            <span class="ml-auto text-gray-600">(ខ្សោយ - Fail)</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Evaluator Information -->
                                    <div class="mb-6">
                                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                            <h4 class="text-sm font-semibold text-gray-800 mb-3">
                                                ហត្ថលេខា និងកាលបរិច្ឆេទ / Signature and Date
                                            </h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        ឈ្មោះអ្នកវាយតម្លៃ / Evaluator Name
                                                    </label>
                                                    <input type="text" 
                                                           name="summary[evaluator_name]" 
                                                           value="{{ auth()->user()->name }}"
                                                           readonly
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                                        កាលបរិច្ឆេទ / Date
                                                    </label>
                                                    <input type="date" 
                                                           name="summary[evaluation_date]" 
                                                           value="{{ date('Y-m-d') }}"
                                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>No evaluation form selected. Please select an evaluation form to continue with final evaluation.</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- No existing evaluations -->
                        <div class="text-center py-8 text-gray-500">
                            <div class="mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No Previous Evaluations Found</h4>
                            <p class="text-gray-600 mb-4">Staff and Self evaluations must be completed before creating a Final evaluation.</p>
                            <div class="space-x-4">
                                <a href="{{ route('evaluation-room.index', $employeeId ? ['tab' => 'staff', 'employeeId' => $employeeId] : ['tab' => 'staff']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                    Create Staff Evaluation
                                </a>
                                <a href="{{ route('evaluation-room.index', $employeeId ? ['tab' => 'self', 'employeeId' => $employeeId] : ['tab' => 'self']) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700">
                                    Create Self Evaluation
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($staffEvaluation || $selfEvaluation)
                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md text-sm font-medium">
                            Submit Final Evaluation
                        </button>
                    </div>
                    @endif
                </div>
            @else
                <!-- Regular Evaluation Section (Self/Staff) -->
                @if($selectedEvaluation)
                    <!-- Section 1: Performance Ratings Instructions -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                        <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-4 mb-4">
                            <h3 class="text-sm font-semibold text-gray-800 mb-2">
                                <span class="text-emerald-700">ផ្នែកទី១៖</span> វិធីសាស្រ្តនៃការវាយតម្លៃសមិទ្ធិការងារ/
                                <span class="text-emerald-700">Section 1:</span> Instruction of Performance Evaluation Review
                        </h3>
                            <p class="text-sm text-gray-700 mb-3">
                                សូមពិនិត្យមើលនិងពិភាក្សាអំពីកត្តាខាងក្រោមរបស់បុគ្គលិកក្នុងតំណែងការងាររបស់ខ្លួន<br>
                                <span class="italic">Carefully evaluate and discuss the following factors of employee in their position</span>
                            </p>
                        </div>

                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-3 text-center">Performance ratings</h4>
                            <div class="space-y-2 text-xs">
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៥- ឆ្នើមល្អ<br><span class="text-blue-600">5 - Excellent</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        លើសពីស្តង់ដារនៃការអនុវត្តការងារ និងបង្ហាញសមិទ្ធផលល្អជាង ៩០% នៃអ្នកដែលធ្វើការងារស្រដៀងគ្នា<br>
                                        <span class="italic">Exceed standard job requirements and performs better than 90% of peers</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៤- ល្អ<br><span class="text-blue-600">4 - Outstanding</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        ជាទូទៅលើសពីស្តង់ដារនៃការអនុវត្តការងារ និងបង្ហាញសមិទ្ធផលល្អជាង ៨០% នៃអ្នកដែលធ្វើការងារស្រដៀងគ្នា<br>
                                        <span class="italic">Often exceeds standard job requirements and performs better than 80% of peers</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">៣- ប្រកបដោយប្រសិទ្ធភាព<br><span class="text-blue-600">3 - Effective</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        បំពេញតាមតម្រូវការការងារបានត្រឹមត្រូវ<br>
                                        <span class="italic">Meets job requirements</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2 border-b border-gray-200">
                                    <div class="font-medium text-gray-700">២-មិនឆ្លៀត<br><span class="text-blue-600">2 - Inconsistent</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        ធ្វើបានបាន តែមិនបានគ្រប់កម្រិតតាមតម្រូវការការងារទាំងអស់<br>
                                        <span class="italic">Meets some jobs but not all job requirements</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 py-2">
                                    <div class="font-medium text-gray-700">១-មិនសោះ<br><span class="text-blue-600">1 - Unsatisfactory</span></div>
                                    <div class="col-span-2 text-gray-600">
                                        មិនអាចធ្វើតាមការណែនាំរបស់ពេលកាលានុវត្តន៍បានត្រឹមត្រូវ (ស្ថិតនៅពីក្រោយពួកដៃគូការងារ)<br>
                                        <span class="italic">Expectation is not able to follow supervisor instructions effective (far behind peer performance)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section 2: Evaluation Criteria -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                        <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-3 mb-4">
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-800">
                                        <span class="text-emerald-700">ផ្នែកទី២:</span> ចំណុចបញ្ជាក់ ការអនុវត្តការងារក្នុងស្ថានភាពជាក់ស្តែង និងការផ្តល់យោបល់របស់ថ្នាក់លើ
                                    </div>
                                    <div class="text-sm text-gray-600 italic">
                                        <span class="text-emerald-700">Section 2:</span> Evaluation points in practice Comments and feedback by Supervisor/Manager
                                    </div>
                                </div>
                                <div class="text-right text-sm font-medium text-gray-700 border-l border-gray-300 pl-3 ml-3">
                                    <div>កិច្ចប្រតិបត្តិ ១-៥</div>
                                    <div>Performance Rating 1-5</div>
                                </div>
                            </div>
                    </div>

                    @if($criteria->count() > 0)
                        @foreach($criteria as $index => $criterion)
                        <div class="mb-6 pb-4 border-b border-gray-100 last:border-b-0">
                                <div class="mb-3">
                                    <div class="flex items-start space-x-3">
                                        <span class="flex items-center justify-center w-6 h-6 bg-emerald-100 text-emerald-600 text-sm font-medium rounded-full mt-0.5">
                                            {{ $criterion->order_number }}
                                        </span>
                                        <div class="flex-1">
                                            <h5 class="font-medium text-gray-900">{{ $criterion->title_kh }}</h5>
                                            <p class="text-sm text-gray-600">{{ $criterion->title_en }}</p>
                                            @if($criterion->description_kh || $criterion->description_en)
                                                <div class="mt-2 text-xs text-gray-500">
                                                    @if($criterion->description_kh)
                                                        <p>{{ $criterion->description_kh }}</p>
                                                    @endif
                                                    @if($criterion->description_en)
                                                        <p class="italic">{{ $criterion->description_en }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="text-sm text-gray-600 block mb-1">យោបល់/Comments & feedback:</label>
                                    <textarea name="evaluation[child_evaluations][{{ $index }}][feedback]" 
                                              rows="2"
                                                  placeholder="Write your evaluation feedback here..."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-none"></textarea>
                                </div>
                                <div class="w-24">
                                    <label class="text-sm text-gray-600 block mb-1">Rating</label>
                                    <select name="evaluation[child_evaluations][{{ $index }}][rating]" 
                                            required
                                            class="w-full px-2 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                        <option value="">Select</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="evaluation[child_evaluations][{{ $index }}][evaluation_id]" value="{{ $criterion->id }}">
                        </div>
                        @endforeach

                        </div>

                        <!-- Section 3: Summary Comments and Overall Rating -->
                        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
                            <div class="bg-emerald-100 border border-emerald-200 rounded-lg p-4 mb-6">
                                <h3 class="text-sm font-semibold text-gray-800">
                                    <span class="text-emerald-700">ផ្នែកទី៣៖</span> សង្ខេបយោបល់ និងកំណត់ហេតុ/
                                    <span class="text-emerald-700">Section 3:</span> Summary comments and feedback
                                </h3>
                            </div>

                            <!-- Improvement Points & Suggestions -->
                            <div class="mb-6">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-3">
                                        ចំណុចកែលម្អ និងការផ្តល់យោបល់ / Improvement Points & Suggestions
                                    </h4>
                                    <textarea name="summary[improvement_points]" 
                                              rows="4"
                                              placeholder="Write improvement suggestions and feedback here..."
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 resize-none"></textarea>
                                </div>
                            </div>

                            <!-- Overall Performance Rating -->
                            <div class="mb-6">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-4 text-center">
                                        តម្លៃសុិទ្ធនៃសមិទ្ធភាពការងារ / Overall performance rating
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Total Score -->
                                        <div class="text-center">
                                            <div class="bg-white border-2 border-gray-300 rounded-lg p-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                                    ពិន្ទុសរុប / Total scores
                                                </label>
                                                <div class="flex items-center justify-center space-x-2">
                                                    <input type="number" 
                                                           id="totalScoreInput"
                                                           name="summary[total_score]" 
                                                           min="0" 
                                                           max="50"
                                                           placeholder="0"
                                                           readonly
                                                           class="w-20 text-center text-lg font-semibold border border-gray-300 rounded-md bg-gray-100 text-gray-700">
                                                    <span class="text-lg font-medium text-gray-600">/ 50 scores</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Grade Selection -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                ចំណាត់ថ្នាក់ / ថ្នាក់
                                            </label>
                                            <div class="space-y-2 text-xs">
                                                <label class="flex items-center">
                                                    <input type="radio" name="summary[grade]" value="A" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="font-medium">A: 46 – 50</span>
                                                    <span class="ml-auto text-gray-600">(ឆ្នើមល្អ - Best)</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="summary[grade]" value="B" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="font-medium">B: 41 – 45</span>
                                                    <span class="ml-auto text-gray-600">(ល្អ - Good)</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="summary[grade]" value="C" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="font-medium">C: 36 – 40</span>
                                                    <span class="ml-auto text-gray-600">(ទទួលយកបាន - Acceptable)</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="summary[grade]" value="D" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="font-medium">D: 31 – 35</span>
                                                    <span class="ml-auto text-gray-600">(ត្រូវកែតម្រូវ - Considering)</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" name="summary[grade]" value="E" disabled class="mr-2 text-emerald-600 focus:ring-emerald-500">
                                                    <span class="font-medium">E: 26 – 30</span>
                                                    <span class="ml-auto text-gray-600">(ខ្សោយ - Fail)</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Evaluator Information -->
                            <div class="mb-6">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-gray-800 mb-3">
                                        ហត្ថលេខា និងកាលបរិច្ឆេទ / Signature and Date
                                    </h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                ឈ្មោះអ្នកវាយតម្លៃ / Evaluator Name
                                            </label>
                                            <input type="text" 
                                                   name="summary[evaluator_name]" 
                                                   value="{{ auth()->user()->name }}"
                                                   readonly
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-600">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                កាលបរិច្ឆេទ / Date
                                            </label>
                                            <input type="date" 
                                                   name="summary[evaluation_date]" 
                                                   value="{{ date('Y-m-d') }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-6">
                            <button type="submit" 
                                        onclick="prepareFormForSubmission()"
                                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-md text-sm font-medium">
                                Submit Evaluation
                            </button>
                            </div>
                        </div>
                    @else
                            <div class="text-center py-8 text-gray-500">
                                <div class="mb-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-lg font-medium text-gray-900 mb-2">No Criteria Found</p>
                                <p>This evaluation form doesn't have any active criteria. Please contact administrator.</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="text-center py-8 text-gray-500">
                            <div class="mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V9a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">No Evaluation Form Selected</h4>
                            <p class="text-gray-600 mb-4">Please select an evaluation form from the dropdown above to begin the evaluation process.</p>
                            @if($allEvaluations->count() > 0)
                                <p class="text-sm text-gray-500">Available forms: {{ $allEvaluations->pluck('title')->join(', ') }}</p>
                            @else
                                <p class="text-sm text-gray-500">No evaluation forms are available. Please contact administrator.</p>
                            @endif
                        </div>
                        </div>
                    @endif
            @endif
        </form>

    </div>
</div>

<script>
function prepareFormForSubmission() {
    // Temporarily enable grade fields so they get submitted
    document.querySelectorAll('input[name="summary[grade]"]').forEach(function(radio) {
        radio.disabled = false;
    });
    
    // For final evaluation, ensure all form fields can be submitted
    if (document.querySelector('input[name="evaluation_type"][value="final"]') && 
        document.querySelector('input[name="evaluation_type"][value="final"]').checked) {
        
        // Temporarily enable final evaluation fields for submission
        document.querySelectorAll('.final-rating').forEach(function(select) {
            select.style.pointerEvents = '';
            select.removeAttribute('readonly');
        });
        
        document.querySelectorAll('.final-feedback').forEach(function(textarea) {
            textarea.removeAttribute('readonly');
        });
        
        // Also enable summary fields for submission
        document.querySelectorAll('textarea[name="summary[improvement_points]"], input[name="summary[evaluator_name]"], input[name="summary[evaluation_date]"]').forEach(function(element) {
            element.removeAttribute('readonly');
        });
    }
}

function submitEvaluation() {
    prepareFormForSubmission();
    document.getElementById('evaluationForm').submit();
}

function changeEvaluationForm(evaluationId) {
    if (evaluationId) {
        const url = new URL(window.location);
        url.searchParams.set('evaluation_id', evaluationId);
        
        // Preserve other parameters
        @if($employeeId)
            url.searchParams.set('employeeId', '{{ $employeeId }}');
        @endif
        @if($activeTab)
            url.searchParams.set('tab', '{{ $activeTab }}');
        @endif
        
        window.location = url;
    }
}

// Auto-search functionality
document.querySelector('input[name="model_data[searchId]"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const employeeId = this.value;
        if (employeeId) {
            const url = new URL(window.location);
            url.searchParams.set('employeeId', employeeId);
            window.location = url;
        }
    }
});

// Auto-populate form if coming from department page with employeeId
@if($employeeId && !empty($modelData['employeeName']))
document.addEventListener('DOMContentLoaded', function() {
    // Pre-fill the employee information
    document.querySelector('input[name="model_data[employeeName]"]').value = '{{ $modelData['employeeName'] }}';
    document.querySelector('input[name="model_data[jobTitle]"]').value = '{{ $modelData['jobTitle'] }}';
    document.querySelector('input[name="model_data[department]"]').value = '{{ $modelData['department'] }}';
});
@endif

@if($activeTab === 'final')
// Final Evaluation JavaScript

// Function to show auto-fill success message
function showAutoFillSuccessMessage(message) {
    // Remove any existing messages first
    const existingMessage = document.getElementById('auto-fill-success-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    // Create success message element
    const messageDiv = document.createElement('div');
    messageDiv.id = 'auto-fill-success-message';
    messageDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2';
    messageDiv.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>${message}</span>
    `;
    
    // Add to page
    document.body.appendChild(messageDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (messageDiv && messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
}

// Function to populate all summary fields
function populateSummaryFields(summaryData) {
    console.log('📋 populateSummaryFields called with:', summaryData);
    
    if (!summaryData) {
        console.log('❌ No summary data provided');
        return;
    }
    
    // Debug: Check what summary fields exist on the page
    const improvementPointsField = document.querySelector('textarea[name="summary[improvement_points]"]');
    const evaluatorNameField = document.querySelector('input[name="summary[evaluator_name]"]');
    const evaluationDateField = document.querySelector('input[name="summary[evaluation_date]"]');
    
    console.log('🔍 Summary field elements found:', {
        improvementPoints: !!improvementPointsField,
        evaluatorName: !!evaluatorNameField,
        evaluationDate: !!evaluationDateField
    });
    
    // Populate improvement points
    if (improvementPointsField) {
        if (summaryData.improvement_points) {
            improvementPointsField.value = summaryData.improvement_points;
            console.log('✅ Set improvement points:', summaryData.improvement_points);
        } else {
            // Set a default message if no improvement points exist
            improvementPointsField.value = 'No specific improvement points noted in the original evaluation.';
            console.log('✅ Set default improvement points (original was null)');
        }
    } else {
        console.log('❌ improvement_points field not found');
    }
    
    // Populate evaluator name
    if (evaluatorNameField) {
        if (summaryData.evaluator_name) {
            evaluatorNameField.value = summaryData.evaluator_name;
            console.log('✅ Set evaluator name:', summaryData.evaluator_name);
        } else {
            console.log('⚠️ No evaluator_name in summary data');
        }
    } else {
        console.log('❌ evaluator_name field not found');
    }
    
    // Populate evaluation date (summary date) - convert from ISO to YYYY-MM-DD format
    if (evaluationDateField) {
        let dateValue = summaryData.summary_date || summaryData.evaluation_date;
        if (dateValue) {
            // Convert ISO date to YYYY-MM-DD format
            if (dateValue.includes('T')) {
                dateValue = dateValue.split('T')[0]; // Extract just the date part
            }
            evaluationDateField.value = dateValue;
            console.log('✅ Set evaluation date (formatted):', dateValue);
        } else {
            console.log('⚠️ No summary_date or evaluation_date in summary data');
        }
    } else {
        console.log('❌ evaluation_date field not found');
    }
}

function handleSourceChange(source) {
    console.log('🚀 handleSourceChange called with source:', source);
    
    const customForm = document.getElementById('custom-evaluation-form');
    const staffData = @json($staffEvaluation ? $staffEvaluation->criteriaResponses : []);
    const selfData = @json($selfEvaluation ? $selfEvaluation->criteriaResponses : []);
    const staffSummary = @json($staffEvaluation);
    const selfSummary = @json($selfEvaluation);
    
    // Debug: Log all the data we received from backend
    console.log('🔍 Debug - Staff Evaluation:', staffSummary);
    console.log('🔍 Debug - Self Evaluation:', selfSummary);
    console.log('🔍 Debug - Staff Criteria Responses:', staffData);
    console.log('🔍 Debug - Self Criteria Responses:', selfData);
    
    // Clear existing form data
    console.log('🧹 Clearing existing form data...');
    document.querySelectorAll('.final-feedback').forEach(textarea => textarea.value = '');
    document.querySelectorAll('.final-rating').forEach(select => select.value = '');
    
    // Debug: Check how many form elements we found
    console.log('📝 Found form elements:', {
        feedbackElements: document.querySelectorAll('.final-feedback').length,
        ratingElements: document.querySelectorAll('.final-rating').length,
        hiddenInputs: document.querySelectorAll('input[name*="[evaluation_id]"]').length
    });
    
    if (source === 'staff' && staffData && staffData.length > 0) {  
        // Populate form with staff evaluation data
        console.log('Staff data:', staffData);
        
        // Get all hidden evaluation_id inputs
        const allHiddenInputs = document.querySelectorAll('input[name*="[evaluation_id]"]');
        console.log('Found hidden inputs:', allHiddenInputs.length);
        
        staffData.forEach((item) => {
            const criteriaId = item.evaluation_criteria_id;
            console.log('Looking for criteria ID:', criteriaId);
            
            // Find the hidden input with matching criteria ID
            let matchingInput = null;
            let matchingIndex = null;
            
            allHiddenInputs.forEach((input, index) => {
                if (input.value == criteriaId) {
                    matchingInput = input;
                    // Extract index from input name: evaluation[child_evaluations][INDEX][evaluation_id]
                    const match = input.name.match(/\[(\d+)\]/);
                    if (match) {
                        matchingIndex = match[1];
                    }
                }
            });
            
            if (matchingInput && matchingIndex !== null) {
                console.log('Found matching input at index:', matchingIndex);
                
                // Use the index to find the corresponding feedback and rating elements
                const feedbackElement = document.querySelector(`textarea[name="evaluation[child_evaluations][${matchingIndex}][feedback]"]`);
                const ratingElement = document.querySelector(`select[name="evaluation[child_evaluations][${matchingIndex}][rating]"]`);
                
                if (feedbackElement) {
                    feedbackElement.value = item.feedback || '';
                    console.log('Set feedback:', item.feedback);
                }
                if (ratingElement) {
                    ratingElement.value = item.rating || '';
                    console.log('Set rating:', item.rating);
                }
            } else {
                console.log('No matching input found for criteria ID:', criteriaId);
            }
        });
        
        // Populate all summary fields from staff evaluation
        populateSummaryFields(staffSummary);
        
        // Make form visually read-only but keep functional for submission
        document.querySelectorAll('.final-feedback, .final-rating').forEach(element => {
            element.style.backgroundColor = '#f3f4f6';
            element.setAttribute('readonly', true);
            if (element.tagName === 'SELECT') {
                element.style.pointerEvents = 'none';
            }
        });
        
        // Also make summary fields read-only
        document.querySelectorAll('textarea[name="summary[improvement_points]"], input[name="summary[evaluator_name]"], input[name="summary[evaluation_date]"]').forEach(element => {
            element.style.backgroundColor = '#f3f4f6';
            element.setAttribute('readonly', true);
        });
        
        // Calculate total score and grade after populating staff data
        setTimeout(() => {
            calculateTotalScoreAndGrade();
            
            // Check if calculation worked
            const totalScoreField = document.querySelector('input[name="summary[total_score]"]');
            const gradeField = document.querySelector('input[name="summary[grade]"]:checked');
            
            console.log('Auto-calculation triggered after staff data population');
            console.log('✅ Total Score calculated:', totalScoreField ? totalScoreField.value : 'not found');
            console.log('✅ Grade assigned:', gradeField ? gradeField.value : 'not found');
            console.log('✅ Staff evaluation data fully loaded - ready to submit!');
            
            // Show success message to user
            showAutoFillSuccessMessage('✅ Staff evaluation auto-filled! All 10 criteria populated. Ready to submit!');
        }, 200);
        
    } else if (source === 'self' && selfData && selfData.length > 0) {
        // Populate form with self evaluation data
        console.log('Self data:', selfData);
        
        // Get all hidden evaluation_id inputs
        const allHiddenInputs = document.querySelectorAll('input[name*="[evaluation_id]"]');
        console.log('Found hidden inputs:', allHiddenInputs.length);
        
        selfData.forEach((item) => {
            const criteriaId = item.evaluation_criteria_id;
            console.log('Looking for criteria ID:', criteriaId);
            
            // Find the hidden input with matching criteria ID
            let matchingInput = null;
            let matchingIndex = null;
            
            allHiddenInputs.forEach((input, index) => {
                if (input.value == criteriaId) {
                    matchingInput = input;
                    // Extract index from input name: evaluation[child_evaluations][INDEX][evaluation_id]
                    const match = input.name.match(/\[(\d+)\]/);
                    if (match) {
                        matchingIndex = match[1];
                    }
                }
            });
            
            if (matchingInput && matchingIndex !== null) {
                console.log('Found matching input at index:', matchingIndex);
                
                // Use the index to find the corresponding feedback and rating elements
                const feedbackElement = document.querySelector(`textarea[name="evaluation[child_evaluations][${matchingIndex}][feedback]"]`);
                const ratingElement = document.querySelector(`select[name="evaluation[child_evaluations][${matchingIndex}][rating]"]`);
                
                if (feedbackElement) {
                    feedbackElement.value = item.feedback || '';
                    console.log('Set feedback:', item.feedback);
                }
                if (ratingElement) {
                    ratingElement.value = item.rating || '';
                    console.log('Set rating:', item.rating);
                }
            } else {
                console.log('No matching input found for criteria ID:', criteriaId);
            }
        });
        
        // Populate all summary fields from self evaluation
        populateSummaryFields(selfSummary);
        
        // Make form visually read-only but keep functional for submission
        document.querySelectorAll('.final-feedback, .final-rating').forEach(element => {
            element.style.backgroundColor = '#f3f4f6';
            element.setAttribute('readonly', true);
            if (element.tagName === 'SELECT') {
                element.style.pointerEvents = 'none';
            }
        });
        
        // Also make summary fields read-only
        document.querySelectorAll('textarea[name="summary[improvement_points]"], input[name="summary[evaluator_name]"], input[name="summary[evaluation_date]"]').forEach(element => {
            element.style.backgroundColor = '#f3f4f6';
            element.setAttribute('readonly', true);
        });
        
        // Calculate total score and grade after populating self data
        setTimeout(() => {
            calculateTotalScoreAndGrade();
            
            // Check if calculation worked
            const totalScoreField = document.querySelector('input[name="summary[total_score]"]');
            const gradeField = document.querySelector('input[name="summary[grade]"]:checked');
            
            console.log('Auto-calculation triggered after self data population');
            console.log('✅ Total Score calculated:', totalScoreField ? totalScoreField.value : 'not found');
            console.log('✅ Grade assigned:', gradeField ? gradeField.value : 'not found');
            console.log('✅ Self evaluation data fully loaded - ready to submit!');
            
            // Show success message to user
            showAutoFillSuccessMessage('✅ Self evaluation auto-filled! All 10 criteria populated. Ready to submit!');
        }, 200);
        
    } else if (source === 'custom') {
        console.log('Switching to custom evaluation mode');
        
        // Clear all form data first (criteria and summary)
        document.querySelectorAll('.final-feedback').forEach(textarea => textarea.value = '');
        document.querySelectorAll('.final-rating').forEach(select => select.value = '');
        document.querySelectorAll('textarea[name="summary[improvement_points]"]').forEach(textarea => textarea.value = '');
        document.querySelectorAll('input[name="summary[evaluator_name]"]').forEach(input => input.value = '');
        document.querySelectorAll('input[name="summary[evaluation_date]"]').forEach(input => input.value = new Date().toISOString().split('T')[0]);
        
        // Enable form for custom input (criteria fields)
        document.querySelectorAll('.final-feedback, .final-rating').forEach(element => {
            element.style.backgroundColor = '';
            element.removeAttribute('readonly');
            element.style.pointerEvents = '';
        });
        
        // Enable summary fields for custom input
        document.querySelectorAll('textarea[name="summary[improvement_points]"], input[name="summary[evaluator_name]"], input[name="summary[evaluation_date]"]').forEach(element => {
            element.style.backgroundColor = '';
            element.removeAttribute('readonly');
        });
        
        // Reset calculation
        setTimeout(() => {
            calculateTotalScoreAndGrade();
            console.log('Auto-calculation reset for custom evaluation');
        }, 100);
    }
}

// Add hidden input to track evaluation source
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('evaluationForm');
    if (form) {
        // Add hidden input for evaluation source
        const sourceInput = document.createElement('input');
        sourceInput.type = 'hidden';
        sourceInput.name = 'evaluation_source';
        sourceInput.value = 'custom';
        form.appendChild(sourceInput);
        
        // Update hidden input when radio buttons change
        document.querySelectorAll('input[name="evaluation_source"]').forEach(radio => {
            radio.addEventListener('change', function() {
                sourceInput.value = this.value;
                console.log('Evaluation source changed to:', this.value);
                // Trigger the source change handler
                handleSourceChange(this.value);
            });
        });
        
        // Check if there's a pre-selected option and trigger it
        const checkedRadio = document.querySelector('input[name="evaluation_source"]:checked');
        if (checkedRadio) {
            handleSourceChange(checkedRadio.value);
        }
    }
});
@endif

// Function to calculate total score and assign grade (global scope)
function calculateTotalScoreAndGrade() {
        let totalScore = 0;
        
        // Get all rating select elements (from Section 2 criteria and final evaluation)
        const ratingElements = document.querySelectorAll('select[name*="[rating]"], .final-rating');
        
        ratingElements.forEach(function(element) {
            const value = parseInt(element.value) || 0;
            totalScore += value;
        });
        
        // Update total score input fields
        const totalScoreInputs = document.querySelectorAll('#totalScoreInput, input[name="summary[total_score]"]');
        totalScoreInputs.forEach(function(input) {
            input.value = totalScore;
        });
        
        // Determine and select grade based on score
        let selectedGrade = '';
        let gradeElement = null;
        
        if (totalScore >= 46) {
            selectedGrade = 'A';
            gradeElement = document.getElementById('gradeA');
        } else if (totalScore >= 41) {
            selectedGrade = 'B';
            gradeElement = document.getElementById('gradeB');
        } else if (totalScore >= 36) {
            selectedGrade = 'C';
            gradeElement = document.getElementById('gradeC');
        } else if (totalScore >= 31) {
            selectedGrade = 'D';
            gradeElement = document.getElementById('gradeD');
        } else if (totalScore >= 26) {
            selectedGrade = 'E';
            gradeElement = document.getElementById('gradeE');
        }
        
        // Clear all grade selections first
        document.querySelectorAll('input[name="summary[grade]"]').forEach(function(radio) {
            radio.checked = false;
            radio.disabled = false; // Temporarily enable to set value
        });
        
        // Select the appropriate grade
        if (gradeElement) {
            gradeElement.checked = true;
        }
        
        // Select all matching grade radios (for duplicate sections)
        document.querySelectorAll(`input[name="summary[grade]"][value="${selectedGrade}"]`).forEach(function(radio) {
            radio.checked = true;
        });
        
        // Re-disable all grade radios (they are auto-calculated)
        document.querySelectorAll('input[name="summary[grade]"]').forEach(function(radio) {
            radio.disabled = true;
        });
        
        // Update visual feedback - highlight selected grade
        document.querySelectorAll('input[name="summary[grade]"]').forEach(function(radio) {
            const label = radio.closest('label');
            if (radio.checked) {
                label.classList.add('bg-emerald-50', 'border', 'border-emerald-200', 'rounded', 'p-1');
            } else {
                label.classList.remove('bg-emerald-50', 'border', 'border-emerald-200', 'rounded', 'p-1');
            }
        });
}

// Real-time total score calculation and grade assignment
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all rating selects (including final evaluation)
    document.querySelectorAll('select[name*="[rating]"], .final-rating').forEach(function(element) {
        element.addEventListener('change', calculateTotalScoreAndGrade);
    });
    
    // Calculate initial values on page load
    calculateTotalScoreAndGrade();
    
    // Add visual indicator that fields are auto-calculated
    const totalScoreInputs = document.querySelectorAll('#totalScoreInput, input[name="summary[total_score]"]');
    totalScoreInputs.forEach(function(input) {
        input.title = 'Total score is automatically calculated from individual ratings';
        input.style.cursor = 'not-allowed';
    });
    
    document.querySelectorAll('input[name="summary[grade]"]').forEach(function(radio) {
        radio.title = 'Grade is automatically assigned based on total score';
        radio.style.cursor = 'not-allowed';
    });
    
    // Add form submit event listener to ensure grade fields are enabled
    const evaluationForm = document.getElementById('evaluationForm');
    if (evaluationForm) {
        evaluationForm.addEventListener('submit', function(e) {
            // Validate final evaluation before submission
            const evaluationType = document.querySelector('input[name="evaluation_type"]').value;
            console.log('📤 Form submission - evaluation type:', evaluationType);
            
            if (evaluationType === 'final') {
                console.log('🔍 Validating final evaluation form...');
                const ratingElements = document.querySelectorAll('.final-rating');
                let hasEmptyRatings = false;
                
                ratingElements.forEach(function(element) {
                    if (!element.value || element.value === '') {
                        hasEmptyRatings = true;
                        element.style.borderColor = '#ef4444'; // Red border for empty fields
                    } else {
                        element.style.borderColor = ''; // Reset border
                    }
                });
                
                if (hasEmptyRatings) {
                    e.preventDefault();
                    console.log('❌ Form validation failed: Empty ratings found');
                    alert('Please fill in all rating fields for the final evaluation.');
                    return false;
                }
                console.log('✅ All ratings are filled');
                
                // Check if evaluator name is filled
                const evaluatorName = document.querySelector('input[name="summary[evaluator_name]"]');
                if (!evaluatorName || !evaluatorName.value.trim()) {
                    e.preventDefault();
                    console.log('❌ Form validation failed: Missing evaluator name');
                    alert('Please enter the evaluator name.');
                    if (evaluatorName) evaluatorName.focus();
                    return false;
                }
                console.log('✅ Evaluator name is filled:', evaluatorName.value);
            }
            
            console.log('🔄 Preparing form for submission...');
            prepareFormForSubmission();
            
            // Debug: Log comprehensive form data being submitted
            const formData = new FormData(evaluationForm);
            console.log('📋 Complete form submission data:');
            
            const formDataObj = {};
            for (let pair of formData.entries()) {
                console.log(`  ${pair[0]}: ${pair[1]}`);
                formDataObj[pair[0]] = pair[1];
            }
            
            // Special debug for final evaluation
            if (evaluationType === 'final') {
                console.log('🎯 Final Evaluation Specific Data:');
                console.log('  - Evaluation Type:', formDataObj['evaluation_type']);
                console.log('  - User ID:', formDataObj['model_data[searchId]']);
                console.log('  - Total Score:', formDataObj['summary[total_score]']);
                console.log('  - Grade:', formDataObj['summary[grade]']);
                console.log('  - Evaluator Name:', formDataObj['summary[evaluator_name]']);
                
                // Count criteria responses
                const criteriaCount = Object.keys(formDataObj).filter(key => key.includes('[rating]')).length;
                console.log('  - Number of criteria with ratings:', criteriaCount);
            }
            
            console.log('🚀 Form ready to submit!');
        });
    }
});
</script>
@endsection 