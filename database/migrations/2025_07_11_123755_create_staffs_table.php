<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('staff_code')->unique()->comment('Staff Code');
            $table->string('en_name');
            $table->string('kh_name');
            $table->longText('description')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->enum('work_contract', ['Permanent', 'Project-based', 'Internship', 'Subcontract'])->default('Permanent');
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->string('status')->default('Active');
            $table->date('start_of_work')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->foreignId('position_id')->constrained('position');
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('department_id')->constrained('department');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
