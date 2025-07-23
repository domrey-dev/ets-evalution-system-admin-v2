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
        Schema::create('evaluation_summaries', function (Blueprint $table) {
            $table->id();
            
            // Evaluation metadata
            $table->unsignedBigInteger('evaluations_id')->comment('Reference to evaluation template');
            $table->unsignedBigInteger('user_id')->comment('Person being evaluated');
            $table->enum('evaluation_type', ['self', 'staff', 'final'])->comment('Type of evaluation');
            $table->date('evaluation_date')->comment('Date when evaluation was conducted');
            
            // Summary results
            $table->integer('total_score')->default(0)->comment('Sum of all criteria scores (0-50)');
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable()->comment('Overall performance grade');
            
            // Section 3: Summary feedback
            $table->text('improvement_points')->nullable()->comment('Improvement suggestions and feedback');
            $table->string('evaluator_name')->comment('Name of the person conducting evaluation');
            $table->date('summary_date')->comment('Date when summary was completed');
            
            // Audit fields
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('evaluations_id')->references('id')->on('evaluations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            
            // Indexes for performance
            $table->index(['user_id', 'evaluation_type', 'evaluation_date']);
            $table->index(['evaluations_id', 'evaluation_date']);
            $table->index('evaluation_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_summaries');
    }
};
