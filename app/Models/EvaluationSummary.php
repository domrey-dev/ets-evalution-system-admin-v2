<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationSummary extends Model
{
    use HasFactory;

    protected $table = 'evaluation_summaries';

    protected $fillable = [
        'evaluations_id',
        'user_id',
        'evaluation_type',
        'evaluation_date',
        'total_score',
        'grade',
        'improvement_points',
        'evaluator_name',
        'summary_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'evaluation_date' => 'date',
        'summary_date' => 'date',
        'total_score' => 'integer',
    ];

    /**
     * Get the evaluation template used for this summary.
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluations::class, 'evaluations_id');
    }

    /**
     * Get the user being evaluated.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user who created this evaluation.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this evaluation.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get all criteria responses for this evaluation.
     */
    public function criteriaResponses(): HasMany
    {
        return $this->hasMany(EvaluationCriteriaResponse::class, 'evaluation_summary_id');
    }

    /**
     * Calculate total score from criteria responses.
     */
    public function calculateTotalScore(): int
    {
        return $this->criteriaResponses()->sum('rating');
    }

    /**
     * Determine grade based on total score.
     */
    public function determineGrade(): ?string
    {
        $score = $this->total_score;
        
        if ($score >= 46) return 'A';
        if ($score >= 41) return 'B';
        if ($score >= 36) return 'C';
        if ($score >= 31) return 'D';
        if ($score >= 26) return 'E';
        
        return null;
    }

    /**
     * Get grade description in Khmer and English.
     */
    public function getGradeDescriptionAttribute(): string
    {
        return match($this->grade) {
            'A' => 'ឆ្នើមល្អ - Best',
            'B' => 'ល្អ - Good',
            'C' => 'ទទួលយកបាន - Acceptable',
            'D' => 'ត្រូវកែតម្រូវ - Considering',
            'E' => 'ខ្សោយ - Fail',
            default => 'Not graded'
        };
    }

    /**
     * Scope for filtering by evaluation type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('evaluation_type', $type);
    }

    /**
     * Scope for filtering by user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for filtering by evaluation template.
     */
    public function scopeUsingTemplate($query, int $evaluationId)
    {
        return $query->where('evaluations_id', $evaluationId);
    }
}
