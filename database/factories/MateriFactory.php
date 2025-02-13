<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Materi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materi>
 */
class MateriFactory extends Factory
{
    protected $model = Materi::class;

    public function definition(): array
    {
        return [
            'id_ekskul' => 1, // Sesuaikan dengan ID ekskul yang ada di database
            'isi_materi' => $this->faker->paragraph(2), // Buat teks random
            'lampiran_materi' => null, // Bisa diisi dengan path file dummy jika perlu
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
