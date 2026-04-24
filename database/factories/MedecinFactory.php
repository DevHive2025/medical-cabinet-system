<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedecinFactory extends Factory
{
    public function definition(): array
    {
        return [
            // This creates a User automatically for every Medecin
            'user_id' => User::factory(), 
            'specialite' => $this->faker->randomElement(['Generaliste', 'Cardiologue', 'Dentiste']),
            // This fixes your "NOT NULL constraint failed" error
            'cabinet_telephone' => $this->faker->phoneNumber(), 
        ];
    }
}