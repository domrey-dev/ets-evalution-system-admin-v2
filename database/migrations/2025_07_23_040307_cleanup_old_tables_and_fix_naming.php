<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update evaluation_criteria to use consistent naming
        if (Schema::hasColumn('evaluation_criteria', 'evaluation_id')) {
            Schema::table('evaluation_criteria', function (Blueprint $table) {
                // Rename evaluation_id to evaluations_id for consistency
                $table->renameColumn('evaluation_id', 'evaluations_id');
            });
        }

        // Drop the old evaluation_results table - no longer needed
        if (Schema::hasTable('evaluation_results')) {
            Schema::dropIfExists('evaluation_results');
        }

        // Drop the unused evaluation_self table
        if (Schema::hasTable('evaluation_self')) {
            Schema::dropIfExists('evaluation_self');
        }

        // Update any foreign key references in evaluation_criteria_responses
        DB::statement('UPDATE evaluation_criteria_responses SET evaluation_criteria_id = ec.id 
                      FROM evaluation_criteria ec 
                      WHERE evaluation_criteria_responses.evaluation_criteria_id = ec.id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the dropped tables if needed for rollback
        
        // Recreate evaluation_self table
        Schema::create('evaluation_self', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluation_id');
            $table->unsignedBigInteger('user_id');
            $table->text('feedback')->nullable();
            $table->integer('rating')->default(0);
            $table->timestamps();
        });

        // Recreate evaluation_results table
        Schema::create('evaluation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_evaluation_id')->nullable();
            $table->string('monthly_performance')->nullable();
            $table->date('evaluation_date')->nullable();
            $table->unsignedBigInteger('evaluations_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->enum('evaluation_type', ['self', 'staff', 'final']);
            $table->text('feedback')->nullable();
            $table->integer('rating')->nullable();
            $table->text('improvement_points')->nullable();
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->string('evaluator_name')->nullable();
            $table->date('summary_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });

        // Rename back the column in evaluation_criteria
        if (Schema::hasColumn('evaluation_criteria', 'evaluations_id')) {
            Schema::table('evaluation_criteria', function (Blueprint $table) {
                $table->renameColumn('evaluations_id', 'evaluation_id');
            });
        }
    }
};
