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
        // Update missing evaluation_date for existing records
        DB::table('evaluation_results')
            ->whereNull('evaluation_date')
            ->update(['evaluation_date' => now()->format('Y-m-d')]);

        // Add a template_id column to distinguish between template reference and criteria reference
        Schema::table('evaluation_results', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->nullable()->after('evaluation_id')
                ->comment('Reference to evaluations table (evaluation template)');
                
            // Add foreign key constraint
            $table->foreign('template_id')->references('id')->on('evaluations')->onDelete('set null');
            
            // Add index for better performance
            $table->index('template_id');
        });

        // Update existing records to set template_id based on evaluation_id
        // This assumes evaluation_id currently points to evaluation_criteria
        DB::statement("
            UPDATE evaluation_results er
            SET template_id = (
                SELECT ec.evaluation_id 
                FROM evaluation_criteria ec 
                WHERE ec.id = er.evaluation_id
            )
            WHERE er.evaluation_id IS NOT NULL
        ");

        // Add comment to clarify the purpose of evaluation_id
        DB::statement("COMMENT ON COLUMN evaluation_results.evaluation_id IS 'Reference to evaluation_criteria.id (specific criterion being evaluated)'");
        DB::statement("COMMENT ON COLUMN evaluation_results.template_id IS 'Reference to evaluations.id (evaluation template/form used)'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_results', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropIndex(['template_id']);
            $table->dropColumn('template_id');
        });
    }
};
