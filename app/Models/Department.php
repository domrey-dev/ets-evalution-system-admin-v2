<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by',
        'staff_id'
    ];
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(EvaluationResult::class, 'department_id');
    }
    public function staff(): belongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
