<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Advertentie;

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
                Advertentie::create([
                    'titel' => 'Advertentie ' . $i,
                    'beschrijving' => 'Dit is een advertentie',
                    'prijs' => rand(10, 100000),
                    'type' => $i % 2 === 0 ? 'verhuur' : 'normaal',
                    'afbeelding_path' => $path,
                    'user_id' => 1,
                    
                ]);
            }
    }
}
