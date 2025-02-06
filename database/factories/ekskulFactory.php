<?php

namespace Database\Factories;

use App\Models\Ekskul;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ekskul>
 */
class EkskulFactory extends Factory
{
    protected $model = Ekskul::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaEkskul = $this->faker->words(3, true);
        return [
            'nama_ekskul' => $namaEkskul,
            'slug' => Str::slug($namaEkskul),
            'jml_anggota' => $this->faker->randomNumber(2, true),
            'id_pembina' => Jabatan::factory(),
            'id_ketua' => Jabatan::factory(),
            'id_sekertaris' => Jabatan::factory(),
            'id_bendahara' => Jabatan::factory(),
            'jadwal' => $this->faker->randomNumber(2, true),
        ];
    }
}
