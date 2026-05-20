<?php

namespace Database\Seeders;

use App\Models\KategoriBarang;
use Illuminate\Database\Seeder;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Seed kategori barang dari data frontend (products.ts & HomePage.tsx).
     * Kategori: Tenda, Carrier, Sleeping Bag, Perlengkapan, Pakaian, Sepatu
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Tenda',        'slug' => 'tenda'],
            ['nama_kategori' => 'Carrier',      'slug' => 'carrier'],
            ['nama_kategori' => 'Sleeping Bag', 'slug' => 'sleeping-bag'],
            ['nama_kategori' => 'Perlengkapan', 'slug' => 'perlengkapan'],
            ['nama_kategori' => 'Pakaian',      'slug' => 'pakaian'],
            ['nama_kategori' => 'Sepatu',       'slug' => 'sepatu'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriBarang::updateOrCreate(
                ['slug' => $kategori['slug']],
                $kategori
            );
        }
    }
}
