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
        Schema::create('evaluation_results', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Self-referential relationship for hierarchical evaluations
            $table->unsignedBigInteger('parent_evaluation_id')
                ->nullable()
                ->comment('Reference to parent evaluation for hierarchical structures');

            // Evaluation metadata
            $table->date('evaluation_date')
                ->nullable()
                ->comment('Date when evaluation was conducted');

            $table->enum('evaluation_type', ['staff', 'self', 'final'])
                ->default('staff')
                ->comment('Type of evaluation: staff, self, or final');

            // Performance data
            $table->string('monthly_performance')
                ->nullable()
                ->comment('Monthly performance summary or rating');

            $table->integer('rating')
                ->nullable()
                ->comment('Numerical rating (1-5 scale)');

            $table->longText('feedback')
                ->nullable()
                ->comment('Detailed evaluation feedback');

            $table->unsignedBigInteger('evaluation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            // Audit trail
            $table->foreignId('created_by')
                ->constrained('users')
                ->comment('User who created the record');

            $table->foreignId('updated_by')
                ->constrained('users')
                ->comment('User who last updated the record');

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('evaluation_date');
            $table->index('evaluation_type');
            $table->index('rating');

            // Renamed the self-reference to be more descriptive
            $table->foreign('parent_evaluation_id')
                ->references('id')
                ->on('evaluation_results')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_results');
    }
};
