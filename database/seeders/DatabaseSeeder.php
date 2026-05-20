<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Urutan penting karena ada foreign key dependencies:
     * 1. Admin (diperlukan oleh FAQ & Ketersediaan)
     * 2. KategoriBarang (diperlukan oleh Barang)
     * 3. Barang (diperlukan oleh FotoBarang & Ketersediaan)
     * 4. FAQ, Testimoni (data konten)
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            KategoriBarangSeeder::class,
            BarangSeeder::class,
            FaqSeeder::class,
            TestimoniSeeder::class,
            PaketSeeder::class,
        ]);
    }
}
