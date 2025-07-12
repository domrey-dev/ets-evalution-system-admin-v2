<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'en_name',
        'kh_name',
        'description',
        'gender',
        'phone',
        'email',
        'address',
        'work_contract',
        'status',
        'start_of_work',
        'end_of_work',
        'created_by',
        'updated_by',
//        'department_id',
//        'position_id',
//        'project_id',
//        'user_id',
//        'role_id'
    ];
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
//    public function evaluations(): HasMany
//    {
//        return $this->hasMany(EvaluationResult::class, 'staff_id');
//    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
    public function project(): HasMany
    {
        return $this->hasMany(Project::class, 'id', 'project_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
