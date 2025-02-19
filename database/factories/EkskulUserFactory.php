<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ekskul;
use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class EkskulUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Creates a new User
            'ekskul_id' => 1, // Creates a new Ekskul or sets it to null
            // 'ekskul_id' => $this->faker->randomElement([Ekskul::factory()]), // Creates a new Ekskul or sets it to null
            'jabatan' => $this->faker->randomElement(Jabatan::pluck('id_jabatan')->unique()), // Creates a new Jabatan or sets it to null
        ];
    }
}
