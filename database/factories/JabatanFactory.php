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
            'kode_jabatan' => $this->faker->lexify('???') . $this->faker->numerify('###'),
            'nama_jabatan' => $namaJabatan,
            'slug' => Str::slug($namaJabatan),
            'id_ekskul' => $this->faker->randomElement(Ekskul::pluck('id_ekskul')->toArray()),
            'id_user' => $this->faker->randomElement(User::pluck('id_user')->toArray()),



        ];
    }
}
