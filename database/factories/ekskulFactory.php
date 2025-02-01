<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ekskulFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'deskripsi' => $this->faker->text,
            'foto' => $this->faker->imageUrl,
            'id_pembina' => $this->faker->randomNumber(),
            'id_ketua' => $this->faker->randomNumber(),
            'jadwal' => $this->faker->date,
            'status' => $this->faker->randomElement(["aktif", "tidak aktif"]),

        ];
    }
}
