<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advertentie;
use App\Models\Advertisement;

class AdvertentieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = 'afbeeldingen/BhYzQ1yiIL4s9J2oRi7vCn9ONMIZvCrzAcLKjawb.jpg';

        // Generate random ads
        for ($i = 1; $i <= 6; $i++) {
            Advertisement::create([
                'title' => 'Advertentie ' . $i,
                'description' => 'Dit is een advertentie',
                'price' => rand(10, 1000),
                'type' => $i % 2 === 0 ? 'Verkoop' : 'Verhuur',
                'image_path' => $path,
                'user_id' => User::where('role_id', Role::where('name', 'Business')->first()->id)->first()->id,

            ]);
        }
    }
}
