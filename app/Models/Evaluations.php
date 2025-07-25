<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluations extends Model
{
    use HasFactory;
    protected $table = 'evaluations';
    protected $fillable = ['title', 'created_by', 'updated_by'];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function evaluationSelf(): HasMany
    {
        return $this->hasMany(EvaluationSelf::class);
    }



    /**
     * Get the criteria for this evaluation.
     */
    public function criteria(): HasMany
    {
        return $this->hasMany(EvaluationCriteria::class, 'evaluations_id');
    }

    /**
     * Get the active criteria for this evaluation, ordered by order_number.
     */
    public function activeCriteria(): HasMany
    {
        return $this->hasMany(EvaluationCriteria::class, 'evaluations_id')
                    ->where('is_active', true)
                    ->orderBy('order_number');
    }

    /**
     * Get evaluation summaries using this template.
     */
    public function evaluationSummaries(): HasMany
    {
        return $this->hasMany(EvaluationSummary::class, 'evaluations_id');
    }
}
