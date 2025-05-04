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
            $table->id()->primary()->index();
            $table->string('name');
            $table->string('category');
            $table->longText('description');
            $table->integer('starting_price');
            $table->string('picture');
            $table->unsignedBigInteger('seller');
            $table->timestamps();
        });

        Schema::create('auctions', function (Blueprint $table) {
            $table->id()->primary()->index();
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('host_id');
            $table->string('name');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('final_price')->nullable();
            $table->integer('no_of_bid')->default(0);
            $table->unsignedBigInteger('payment_id')->default(0);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->longText('massage')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->boolean('payment')->default(0);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('auction_id')->constrained('auctions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('payer');
            $table->unsignedBigInteger('withdrawer')->default(0);
            /* $table->unsignedBigInteger('bidding_id');
            $table->foreign('bidding_id')->references('id')->on('bidding')->onUpdate('cascade')->onDelete('cascade'); */
            $table->integer('amount');
            $table->integer('commission');
            $table->string('gateway');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidding');
        Schema::dropIfExists('product');
        Schema::dropIfExists('payment');
    }
};
