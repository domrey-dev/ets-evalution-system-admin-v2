<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staffs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'staff_id',
        'en_name',
        'kh_name',
        'description',
        'gender',
        'phone',
        'email',
        'work_contract',
        'status',
        'start_of_work',
        'created_by',
        'updated_by',
        'department_id',
        'position_id',
        'project_id',
    ];
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function department(): hasMany
    {
        return $this->hasMany(Department::class, 'department_id');
    }
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class );
    }

    // Old relationships removed - using new evaluation system

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
