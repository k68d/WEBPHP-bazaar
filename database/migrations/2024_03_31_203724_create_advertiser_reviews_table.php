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
        Schema::create('advertiser_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertiser_id'); 
            $table->unsignedBigInteger('reviewer_id'); 
            $table->text('review');
            $table->unsignedTinyInteger('rating'); 
            $table->timestamps();
        
            $table->foreign('advertiser_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertiser_reviews');
    }
};
