<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\EvaluationSummary;
use App\Models\EvaluationCriteriaResponse;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, migrate parent records (summary data) from evaluation_results to evaluation_summaries
        $parentRecords = DB::table('evaluation_results')
            ->whereNull('parent_evaluation_id')
            ->get();

        foreach ($parentRecords as $parent) {
            // Create evaluation summary record
            $summaryId = DB::table('evaluation_summaries')->insertGetId([
                'evaluations_id' => $parent->evaluations_id,
                'user_id' => $parent->user_id,
                'evaluation_type' => $parent->evaluation_type,
                'evaluation_date' => $parent->evaluation_date,
                'total_score' => $parent->monthly_performance ?? 0,
                'grade' => $parent->grade,
                'improvement_points' => $parent->improvement_points,
                'evaluator_name' => $parent->evaluator_name ?? 'Unknown',
                'summary_date' => $parent->summary_date ?? $parent->evaluation_date,
                'created_by' => $parent->created_by,
                'updated_by' => $parent->updated_by,
                'created_at' => $parent->created_at,
                'updated_at' => $parent->updated_at,
            ]);

            // Now migrate child records (criteria responses) for this parent
            $childRecords = DB::table('evaluation_results')
                ->where('parent_evaluation_id', $parent->id)
                ->get();

            foreach ($childRecords as $child) {
                // Skip if this combination already exists (handle duplicates)
                $exists = DB::table('evaluation_criteria_responses')
                    ->where('evaluation_summary_id', $summaryId)
                    ->where('evaluation_criteria_id', $child->evaluation_id ?? 1)
                    ->exists();
                
                if (!$exists) {
                    DB::table('evaluation_criteria_responses')->insert([
                        'evaluation_summary_id' => $summaryId,
                        'evaluation_criteria_id' => $child->evaluation_id ?? 1, // Fallback to 1 if null
                        'rating' => $child->rating ?? 0,
                        'feedback' => $child->feedback ?? '',
                        'created_at' => $child->created_at,
                        'updated_at' => $child->updated_at,
                    ]);
                }
            }
        }

        // Handle orphaned child records (records with parent_evaluation_id but parent doesn't exist)
        $orphanedRecords = DB::table('evaluation_results')
            ->whereNotNull('parent_evaluation_id')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('evaluation_results as parent')
                    ->whereRaw('parent.id = evaluation_results.parent_evaluation_id')
                    ->whereNull('parent.parent_evaluation_id');
            })
            ->get();

        if ($orphanedRecords->count() > 0) {
            // Create a summary record for orphaned criteria responses
            foreach ($orphanedRecords->groupBy('user_id') as $userId => $userOrphans) {
                foreach ($userOrphans->groupBy('evaluation_type') as $evaluationType => $typeOrphans) {
                    $firstRecord = $typeOrphans->first();
                    
                    $summaryId = DB::table('evaluation_summaries')->insertGetId([
                        'evaluations_id' => $firstRecord->evaluations_id ?? 1,
                        'user_id' => $userId,
                        'evaluation_type' => $evaluationType,
                        'evaluation_date' => $firstRecord->evaluation_date ?? now(),
                        'total_score' => $typeOrphans->sum('rating'),
                        'grade' => $this->calculateGrade($typeOrphans->sum('rating')),
                        'improvement_points' => 'Migrated from orphaned records',
                        'evaluator_name' => 'System Migration',
                        'summary_date' => $firstRecord->evaluation_date ?? now(),
                        'created_by' => $firstRecord->created_by ?? 1,
                        'updated_by' => $firstRecord->updated_by ?? 1,
                        'created_at' => $firstRecord->created_at ?? now(),
                        'updated_at' => $firstRecord->updated_at ?? now(),
                    ]);

                    foreach ($typeOrphans as $orphan) {
                        // Skip if this combination already exists (handle duplicates)
                        $exists = DB::table('evaluation_criteria_responses')
                            ->where('evaluation_summary_id', $summaryId)
                            ->where('evaluation_criteria_id', $orphan->evaluation_id ?? 1)
                            ->exists();
                        
                        if (!$exists) {
                            DB::table('evaluation_criteria_responses')->insert([
                                'evaluation_summary_id' => $summaryId,
                                'evaluation_criteria_id' => $orphan->evaluation_id ?? 1,
                                'rating' => $orphan->rating ?? 0,
                                'feedback' => $orphan->feedback ?? '',
                                'created_at' => $orphan->created_at,
                                'updated_at' => $orphan->updated_at,
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the new tables (data can be restored from evaluation_results if needed)
        DB::table('evaluation_criteria_responses')->truncate();
        DB::table('evaluation_summaries')->truncate();
    }

    /**
     * Calculate grade based on total score.
     */
    private function calculateGrade(int $totalScore): string
    {
        if ($totalScore >= 46) return 'A';
        if ($totalScore >= 41) return 'B';
        if ($totalScore >= 36) return 'C';
        if ($totalScore >= 31) return 'D';
        if ($totalScore >= 26) return 'E';
        return 'E'; // Default for very low scores
    }
};
