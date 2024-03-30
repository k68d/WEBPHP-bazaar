<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        // Haal twee unieke gebruikers op. Maak nieuwe aan indien nodig.
        $userOne = User::inRandomOrder()->first() ?? User::factory()->create();
        $userTwo = User::where('id', '!=', $userOne->id)->inRandomOrder()->first() ?? User::factory()->create();

        return [
            'user_id_one' => $userOne->id,
            'user_id_two' => $userTwo->id,
            'description' => $this->faker->sentence,
            'contract_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['Concept', 'Actief', 'Voltooid']),
            'additional_info' => $this->faker->paragraph,
        ];
    }
}
