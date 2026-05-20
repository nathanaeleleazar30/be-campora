<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Seed paket dari data frontend PaketPage.tsx.
     */
    public function run(): void
    {
        $pakets = [
            [
                'nama_paket'  => 'PAKET BASIC CAMP SET',
                'deskripsi'   => 'Cocok untuk pemula atau camping ringan 2 orang. Praktis dan mudah dibawa.',
                'items'       => [
                    '1x Tenda Kapasitas 2 Orang',
                    '2x Sleeping Bag Polar',
                    '2x Matras Spons',
                    '1x Lampu Tenda',
                    '1x Nesting & Kompor Portable',
                ],
                'harga'       => 150000,
                'is_featured' => false,
            ],
            [
                'nama_paket'  => 'PAKET FAMILY CAMP',
                'deskripsi'   => 'Paket premium untuk kenyamanan maksimal liburan keluarga di alam terbuka.',
                'items'       => [
                    '1x Tenda Tunnel Kapasitas 6-8P',
                    '4x Air Mattress & Pompa',
                    '4x Kursi Lipat Premium',
                    '1x Meja Lipat Besar',
                    'Lampu Hias & Penerangan Ekstra',
                ],
                'harga'       => 500000,
                'is_featured' => true,
            ],
            [
                'nama_paket'  => 'PAKET HIKING',
                'deskripsi'   => 'Peralatan lengkap untuk pendakian gunung tingkat menengah hingga sulit.',
                'items'       => [
                    '1x Tenda Dome Double Layer 4P',
                    '4x Sleeping Bag Mummy',
                    '1x Carrier 60L + Cover',
                    '4x Trekking Pole',
                    '1x Set Alat Masak Lengkap',
                    '2x Headlamp LED',
                ],
                'harga'       => 350000,
                'is_featured' => false,
            ],
        ];

        foreach ($pakets as $paket) {
            Paket::updateOrCreate(
                ['nama_paket' => $paket['nama_paket']],
                $paket
            );
        }
    }
}
