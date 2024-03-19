<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mobil>
 */
class MobilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fotoMobil = 'bangkit_' . $this->faker->unique()->numberBetween(1, 100) . '.jpg';
        Storage::disk('public')->put('foto-mobil/' . $fotoMobil, file_get_contents(public_path('source/bangkit.jpg')));

        return [
            'nama' => 'Mobil-' . $this->faker->unique()->numberBetween(1, 100),
            'merk' => 'Merk-' . $this->faker->unique()->numberBetween(1, 50),
            'warna' => $this->faker->colorName(),
            'tahun' => $this->faker->year(),
            'plat_nomor' => $this->faker->unique()->regexify('[A-Z]{1,2} \d{1,4} [A-Z]{1,3}'),
            'keterangan' => $this->faker->paragraph(),
            'harga' => $this->faker->numberBetween(100000, 1000000),
            'status' => $this->faker->randomElement(['Tersedia', 'Disewa', 'Rusak']),
            'kapasitas_penumpang' => $this->faker->numberBetween(2, 8),
            'foto' => $fotoMobil,
        ];
    }
}
