<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationCriteria extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evaluation_criteria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'evaluation_id',
        'title_kh',
        'title_en',
        'description_kh',
        'description_en',
        'order_number',
        'weight',
        'is_active',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
        'order_number' => 'integer'
    ];

    /**
     * Get the evaluation that owns the criteria.
     */
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluations::class, 'evaluation_id');
    }

    /**
     * Get the user who created this criteria.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this criteria.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include active criteria.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by order_number.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_number');
    }

    /**
     * Get the full title (Khmer and English).
     */
    public function getFullTitleAttribute(): string
    {
        return $this->title_kh . ' / ' . $this->title_en;
    }

    /**
     * Get the full description (Khmer and English).
     */
    public function getFullDescriptionAttribute(): string
    {
        return $this->description_kh . ' / ' . $this->description_en;
    }
} 