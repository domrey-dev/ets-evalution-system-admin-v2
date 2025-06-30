<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationSelf extends Model
{
    //
    use HasFactory;
    protected $table = 'evaluation_self';
    protected $fillable = ['comment', 'created_by', 'updated_by', 'evaluation_id'];
    public function evaluation(): BelongsTo
    {
        return $this->belongsTo(Evaluations::class);
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
