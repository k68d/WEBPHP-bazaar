<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `titel` `title` VARCHAR(191)');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `beschrijving` `description` TEXT');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `prijs` `price` DECIMAL(10, 2)');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `afbeelding_path` `image_path` VARCHAR(255)');
    }

    public function down(): void
    {
        // Reverse the manual renaming
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `title` `titel` VARCHAR(191)');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `description` `beschrijving` TEXT');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `price` `prijs` DECIMAL(10, 2)');
        DB::statement('ALTER TABLE advertisements CHANGE COLUMN `image_path` `afbeelding_path` VARCHAR(255)');
    }
};
