<?php

namespace Database\Factories;

use App\Models\Ekskul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kuis>
 */
class KuisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kuis' => $this->faker->sentence(3), // Nama kuis lebih jelas
            'isi_kuis' => $this->faker->url, // Menghasilkan URL valid
            'id_ekskul' => $this->faker->randomElement(Ekskul::pluck('id_ekskul')->toArray()),
        ];
    }
}
