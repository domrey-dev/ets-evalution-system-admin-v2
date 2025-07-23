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
        Schema::table('evaluation_results', function (Blueprint $table) {
            // Section 3: Summary fields
            $table->text('improvement_points')->nullable()->after('feedback')->comment('Improvement suggestions and feedback');
            $table->integer('total_score')->nullable()->after('improvement_points')->comment('Total evaluation score (0-50)');
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable()->after('total_score')->comment('Overall performance grade');
            $table->string('evaluator_name')->nullable()->after('grade')->comment('Name of the person conducting the evaluation');
            $table->date('summary_date')->nullable()->after('evaluator_name')->comment('Date when summary was completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_results', function (Blueprint $table) {
            $table->dropColumn([
                'improvement_points',
                'total_score', 
                'grade',
                'evaluator_name',
                'summary_date'
            ]);
        });
    }
};
