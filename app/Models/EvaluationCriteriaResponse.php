<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationCriteriaResponse extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria_responses';

    protected $fillable = [
        'evaluation_summary_id',
        'evaluation_criteria_id',
        'rating',
        'feedback',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the evaluation summary this response belongs to.
     */
    public function evaluationSummary(): BelongsTo
    {
        return $this->belongsTo(EvaluationSummary::class, 'evaluation_summary_id');
    }

    /**
     * Get the criteria this response is for.
     */
    public function evaluationCriteria(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriteria::class, 'evaluation_criteria_id');
    }

    /**
     * Get rating description.
     */
    public function getRatingDescriptionAttribute(): string
    {
        return match($this->rating) {
            5 => 'Outstanding',
            4 => 'Good', 
            3 => 'Satisfactory',
            2 => 'Needs Improvement',
            1 => 'Unsatisfactory',
            default => 'Not rated'
        };
    }

    /**
     * Scope for filtering by rating.
     */
    public function scopeWithRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for filtering by evaluation summary.
     */
    public function scopeForSummary($query, int $summaryId)
    {
        return $query->where('evaluation_summary_id', $summaryId);
    }

    /**
     * Scope for filtering by criteria.
     */
    public function scopeForCriteria($query, int $criteriaId)
    {
        return $query->where('evaluation_criteria_id', $criteriaId);
    }
}
