<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add session_id column for guest cart support
     * Make user_id nullable to support both authenticated and guest users
     */
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Make user_id nullable for guest support
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add session_id for guest cart tracking
            $table->string('session_id')->nullable()->after('user_id');
            
            // Add index for better query performance
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Remove session_id column and index
            $table->dropIndex(['session_id']);
            $table->dropColumn('session_id');
            
            // Revert user_id to non-nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
