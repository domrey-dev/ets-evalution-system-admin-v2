<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluationResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'parent_evaluation_id',
        'monthly_performance',
        'evaluation_date',
        'evaluation_id',
        'user_id',
        'evaluation_type',
        'feedback',
        'rating',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'evaluation_date' => 'date',
    ];

    /**
     * The evaluation types available.
     *
     * @var array<string>
     */
    public const EVALUATION_TYPES = [
        'staff' => 'Staff Evaluation',
        'self' => 'Self Evaluation',
        'final' => 'Final Evaluation'
    ];

    /**
     * Get the department associated with the evaluation result.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the evaluation form/template associated with this result.
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluations::class);
    }

    /**
     * Get the user (employee) being evaluated.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who created this evaluation result.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this evaluation result.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the parent evaluation if this is a child evaluation.
     */
    public function parentEvaluation(): BelongsTo
    {
        return $this->belongsTo(EvaluationResult::class, 'parent_evaluation_id');
    }

    /**
     * Get child evaluations (for hierarchical structures).
     */
    public function childEvaluations(): HasMany
    {
        return $this->hasMany(EvaluationResult::class, 'parent_evaluation_id');
    }

    /**
     * Scope a query to only include evaluations of a specific type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('evaluation_type', $type);
    }

    /**
     * Get the human-readable evaluation type.
     *
     * @return string
     */
    public function getEvaluationTypeNameAttribute(): string
    {
        return self::EVALUATION_TYPES[$this->evaluation_type] ?? 'Unknown Type';
    }
}
