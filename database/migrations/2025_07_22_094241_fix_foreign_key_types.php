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
        Schema::table('users', function (Blueprint $table) {
            // Drop existing foreign key constraints if they exist
            $table->dropColumn(['department_id', 'position_id', 'project_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Add proper foreign key columns
            $table->unsignedBigInteger('department_id')->nullable()->after('name');
            $table->unsignedBigInteger('position_id')->nullable()->after('role');
            $table->unsignedBigInteger('project_id')->nullable()->after('gender');
            
            // Add foreign key constraints
            $table->foreign('department_id')->references('id')->on('department')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('position')->onDelete('set null');
            // Note: project foreign key constraint should be added when projects table structure is confirmed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['department_id']);
            $table->dropForeign(['position_id']);
            
            // Drop the columns
            $table->dropColumn(['department_id', 'position_id', 'project_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Restore original string columns
            $table->string('department_id')->nullable()->after('name');
            $table->string('position_id')->nullable()->after('role');
            $table->string('project_id')->nullable()->after('gender');
        });
    }
};
