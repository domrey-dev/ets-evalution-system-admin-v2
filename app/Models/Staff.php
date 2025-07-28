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
        'staff_code',
        'en_name',
        'kh_name',
        'description',
        'email',
        'phone',
        'work_contract',
        'gender',
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
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
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
