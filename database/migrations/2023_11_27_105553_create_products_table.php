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
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->string('family_color');
            $table->string('group_code');
            $table->float('product_price');
            $table->float('product_discount');
            $table->string('discount_type');
            $table->float('final_price');
            $table->string('product_video');
            $table->text('description');
            $table->text('wash_care');
            $table->text('keywords');
            $table->string('fabric');
            $table->string('sleeve');
            $table->string('fit');
            $table->string('occassion');
            $table->string('pattern');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->enum('is_featured',['No','Yes']);
            $table->tinyInteger('status');
            $table->timestamps();
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
