<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('page_url')->unique();
            $table->json('palette')->nullable();
            $table->json('text_style')->nullable();
            $table->json('components')->nullable(); // Dit veld bevat de gekozen componenten en hun instellingen
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_settings');
    }
};
