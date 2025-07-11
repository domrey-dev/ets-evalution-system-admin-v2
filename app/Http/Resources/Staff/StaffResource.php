<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\DepartmentResource;
use App\Http\Resources\Evaluation\EvaluationResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class StaffResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'en_name' => $this->en_name,
            'kh_name' => $this->kh_name,
            'description' => $this->description,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'work_contract' => $this->work_contract,
            'status' => $this->status,
            'start_of_work' => $this->start_of_work ? Carbon::parse($this->start_of_work)->format('Y-m-d') : null,
            'end_of_work' => $this->end_of_work ? Carbon::parse($this->end_of_work)->format('Y-m-d') : null,
            'position' => $this->position,
            'department' => new DepartmentResource($this->department),
            'project' => new ProjectResource($this->project),
            'role_id' => new RoleResource($this->role),
            'evaluations' => new EvaluationResource($this->evaluation),
            'createdBy' => new UserResource($this->createdBy),
            'updatedBy' => new UserResource($this->updatedBy),
        ];
    }
}
