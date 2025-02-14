<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jabatan;
use App\Models\Ekskul;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static $usedJabatan = [];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->numberBetween(2223607006, 2223608000), // Ensure unique 10-digit number
            'password' => bcrypt('password'), // Set a default password (you can change it as needed)
            'nama' => $this->faker->name,
            'id_kelas' => $this->faker->randomElement([Kelas::inRandomOrder()->first()?->id_kelas, null]), // Random Kelas ID or null
            'role' => $this->faker->randomElement(['admin', 'user']), // Randomly assign 'admin' or 'user'
        ];
    }

    /**
     * Get a unique Jabatan ID for each user.
     *
     * @return int|null
     */
    protected function getUniqueJabatan()
    {
        $jabatan = Jabatan::inRandomOrder()->first();

        // If Jabatan is available and hasn't been used yet, return it
        if ($jabatan && !in_array($jabatan->id_jabatan, self::$usedJabatan)) {
            self::$usedJabatan[] = $jabatan->id_jabatan;
            return $jabatan->id_jabatan;
        }

        // If no more unique Jabatan can be assigned, return null
        return null;
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function admin()
    {
        return $this->state([
            'role' => 'admin',
            'id_kelas' => null,
            'id_ekskul' => null,
            'id_jabatan' => null, // Ensures null value for admin role
        ]);
    }

    /**
     * Indicate that the user is a regular user.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function regularUser()
    {
        return $this->state([
            'role' => 'user',
        ]);
    }

    /**
     * Reset the used jabatan array (for testing or manual resets).
     */
    public static function resetUsedJabatan()
    {
        self::$usedJabatan = [];
    }
}
