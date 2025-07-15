<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Staff::factory()->state(['position_id' => 1])->create();
    }
}
