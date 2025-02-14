<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ekskul;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jabatan>
 */
class JabatanFactory extends Factory
{
    protected $model = Jabatan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaJabatan = $this->faker->words(3, true);
        return [
            'nama_jabatan' => $namaJabatan,
            'slug' => Str::slug($namaJabatan),
        ];
    }
}
