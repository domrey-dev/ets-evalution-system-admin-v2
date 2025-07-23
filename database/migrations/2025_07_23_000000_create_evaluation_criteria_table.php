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
        Schema::create('evaluation_criteria', function (Blueprint $table) {
            $table->id();
            
            // Foreign key to evaluations table (evaluation template)
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            
            // Criteria details
            $table->string('title_kh'); // Khmer title
            $table->string('title_en'); // English title
            $table->text('description_kh'); // Khmer description
            $table->text('description_en'); // English description
            
            // Order for displaying criteria
            $table->integer('order_number')->default(1);
            
            // Weight/importance of this criteria (optional for future use)
            $table->decimal('weight', 5, 2)->default(1.0);
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Audit fields
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            
            $table->timestamps();
            
            // Indexes
            $table->index(['evaluation_id', 'order_number']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria');
    }
}; 