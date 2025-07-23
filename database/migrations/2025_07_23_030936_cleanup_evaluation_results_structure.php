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
        Schema::table('evaluation_results', function (Blueprint $table) {
            // 1. Rename template_id to evaluations_id
            $table->renameColumn('template_id', 'evaluations_id');
        });

        // Update monthly_performance to store total_score data
        DB::statement("
            UPDATE evaluation_results 
            SET monthly_performance = COALESCE(total_score::text, monthly_performance)
            WHERE total_score IS NOT NULL
        ");

        Schema::table('evaluation_results', function (Blueprint $table) {
            // 2. Drop evaluation_id since it's not needed (we're storing evaluations_id instead)
            $table->dropColumn('evaluation_id');
            
            // 3. Drop total_score since monthly_performance will store this value
            $table->dropColumn('total_score');
        });

        // Update column comments for clarity
        DB::statement("COMMENT ON COLUMN evaluation_results.evaluations_id IS 'Reference to evaluations.id (evaluation template/form used)'");
        DB::statement("COMMENT ON COLUMN evaluation_results.monthly_performance IS 'Total score or performance rating for the evaluation'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_results', function (Blueprint $table) {
            // Restore the dropped columns
            $table->unsignedBigInteger('evaluation_id')->nullable()->after('evaluations_id');
            $table->integer('total_score')->nullable()->after('improvement_points');
            
            // Rename back to template_id
            $table->renameColumn('evaluations_id', 'template_id');
        });
    }
};
