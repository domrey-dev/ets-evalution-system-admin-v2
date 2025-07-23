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
        Schema::create('evaluation_criteria_responses', function (Blueprint $table) {
            $table->id();
            
            // Relationships
            $table->unsignedBigInteger('evaluation_summary_id')->comment('Reference to evaluation summary');
            $table->unsignedBigInteger('evaluation_criteria_id')->comment('Reference to specific criterion');
            
            // Response data
            $table->tinyInteger('rating')->comment('Score given for this criterion (1-5)');
            $table->text('feedback')->nullable()->comment('Comments/feedback for this criterion');
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('evaluation_summary_id')->references('id')->on('evaluation_summaries')->onDelete('cascade');
            $table->foreign('evaluation_criteria_id')->references('id')->on('evaluation_criteria')->onDelete('cascade');
            
            // Indexes for performance
            $table->index('evaluation_summary_id');
            $table->index('evaluation_criteria_id');
            
            // Ensure one response per criterion per evaluation
            $table->unique(['evaluation_summary_id', 'evaluation_criteria_id'], 'unique_criterion_response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria_responses');
    }
};
