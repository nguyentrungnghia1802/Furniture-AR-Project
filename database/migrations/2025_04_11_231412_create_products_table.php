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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('descriptions')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->integer('discount_percent')->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('image_url', 400)->nullable();
            $table->unsignedBigInteger('category_id');
            
            // AR-specific fields (Luna Shop addition)
            $table->boolean('ar_enabled')->default(false);
            $table->string('ar_model_glb')->nullable();
            $table->string('ar_model_usdz')->nullable();
            $table->string('ar_model_size')->nullable();
            $table->string('ar_placement_instructions')->nullable();
            $table->decimal('width_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->decimal('depth_cm', 8, 2)->nullable();
            
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index(['category_id', 'price']);
            $table->index('view_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
