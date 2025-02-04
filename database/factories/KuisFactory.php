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
            'nama_kuis' => $this->faker->word,
            'isi_kuis' => $this->faker->text(200), // Kuis maksimal 200 karakter
            'id_ekskul' => $this->faker->randomElement(Ekskul::pluck('id_ekskul')->toArray()),
        ];
    }
}
