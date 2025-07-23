<?php
// Simple script to clear database data while keeping structure
// Run with: php clear_db_data.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Clearing database data...\n";
    
    // Clear evaluation data
    DB::table('evaluation_criteria_responses')->delete();
    echo "✓ evaluation_criteria_responses cleared\n";
    
    DB::table('evaluation_summaries')->delete();
    echo "✓ evaluation_summaries cleared\n";
    
    // Clear other related data
    DB::table('model_has_roles')->delete();
    echo "✓ model_has_roles cleared\n";
    
    DB::table('model_has_permissions')->delete();
    echo "✓ model_has_permissions cleared\n";
    
    DB::table('tasks')->delete();
    echo "✓ tasks cleared\n";
    
    DB::table('projects')->delete();
    echo "✓ projects cleared\n";
    
    DB::table('staffs')->delete();
    echo "✓ staffs cleared\n";
    
    // Keep admin user (id=1), delete others
    $deleted = DB::table('users')->where('id', '>', 1)->delete();
    echo "✓ $deleted users deleted (kept admin)\n";
    
    echo "\nDatabase data cleared successfully!\n";
    echo "You can now run: php artisan migrate --seed\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 