<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    /**
     * Seed testimoni dari data yang ada di frontend HomePage.tsx & ReviewPage.tsx.
     */
    public function run(): void
    {
        $testimonis = [
            [
                'nama_customer' => 'Bintang Fatahillah',
                'rating'        => 5,
                'isi_review'    => 'Peralatannya lengkap dan kondisinya bagus. Proses sewa juga gampang, tinggal cek di website terus langsung hubungi lewat WhatsApp. Pelayanannya cepat dan responsif.',
            ],
            [
                'nama_customer' => 'Nathanael Eleazar',
                'rating'        => 5,
                'isi_review'    => 'Enak sih nyewanya, tinggal chat langsung beres. Nentuin tanggal juga gampang, jadi nggak ribet. Kemarin sewa tenda sama sleeping bag, semuanya oke dipake.',
            ],
            [
                'nama_customer' => 'Abdullah Hammad',
                'rating'        => 5,
                'isi_review'    => 'Nyewa di sini enak, nggak pake ribet. Tinggal tanya-tanya dikit langsung dibantu. Barangnya juga bersih, keliatan dirawat.',
            ],
            [
                'nama_customer' => 'Raihan Ferriand',
                'rating'        => 5,
                'isi_review'    => 'Enak banget buat yang nggak mau ribet prepare alat sendiri. Tinggal sewa, semua udah siap. Kemarin gue pake buat seharian dan semuanya aman. Balikin juga gampang, nggak dipersulit.',
            ],
        ];

        foreach ($testimonis as $testimoni) {
            Testimoni::updateOrCreate(
                ['nama_customer' => $testimoni['nama_customer']],
                $testimoni
            );
        }
    }
}
