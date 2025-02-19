<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\User;
use App\Models\Ekskul;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition()
    {
        return [
            'id_ekskul' => Ekskul::inRandomOrder()->first()->id_ekskul ?? 1,
            'id_user' => User::inRandomOrder()->first()->id ?? 1,
            'tanggal' => Carbon::now()->toDateString(),
            'kehadiran' => $this->faker->randomElement(['hadir', 'izin', 'sakit', 'alpa']),
            'status' => 'terverifikasi',
            
        ];
    }
}
