<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kelas' => $this->faker->randomElement(['10', '11', '12']),
            'jurusan' => $this->faker->randomElement(['PPLG', 'ANM', 'DKV', 'BDP', 'AKT']),
            'nomor_kelas' => $this->faker->randomElement(['1', '2', '3']),
        ];
    }
}
