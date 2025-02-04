<?php

namespace Database\Factories;

use App\Models\Ekskul;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materi>
 */
class MateriFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_ekskul' => $this->faker->randomElement(Ekskul::pluck('id_ekskul')->toArray()),
            'isi_materi' => $this->faker->text(200), // Materi maksimal 200 karakter
            'lampiran_materi' => $this->faker->word, // Lampiran berbentuk kata acak
        ];
    }
}
