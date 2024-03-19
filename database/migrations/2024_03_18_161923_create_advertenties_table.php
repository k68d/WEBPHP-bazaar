<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advertenties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titel');
            $table->text('beschrijving');
            $table->decimal('prijs', 8, 2);
            $table->string('type'); // 'normaal' of 'verhuur'
            $table->string('afbeelding_path')->nullable(); // Pad naar de afbeelding
            $table->unsignedBigInteger('user_id'); // Foreign key naar users tabel
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('advertenties');
    }
};
