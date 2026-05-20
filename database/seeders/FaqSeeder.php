<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Seed FAQ dari data yang ada di frontend FAQPage.tsx.
     */
    public function run(): void
    {
        $admin = Admin::first();
        $adminId = $admin?->id_admin ?? 1;

        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara menyewa alat camping di website ini?',
                'jawaban'    => 'Pilih perlengkapan yang diinginkan dari katalog, cek ketersediaan pada tanggal yang diinginkan, lalu klik tombol "Hubungi Admin" untuk melakukan konfirmasi melalui WhatsApp. Setelah itu, Anda bisa mengambil barang di lokasi sesuai kesepakatan.',
            ],
            [
                'pertanyaan' => 'Apakah saya bisa mengecek ketersediaan barang sebelum menyewa?',
                'jawaban'    => 'Ya, Anda bisa langsung melihat status ketersediaan produk di halaman Katalog kami. Untuk kepastian stok real-time, silakan hubungi kami melalui WhatsApp atau email sebelum melakukan pemesanan.',
            ],
            [
                'pertanyaan' => 'Bagaimana sistem pembayaran untuk penyewaan?',
                'jawaban'    => 'Kami menerima pembayaran melalui transfer bank (BCA, Mandiri, BNI), e-wallet (GoPay, OVO, Dana), serta tunai di tempat. Diperlukan DP 50% untuk mengkonfirmasi dan mengamankan pesanan Anda. Pelunasan dilakukan saat pengambilan barang.',
            ],
            [
                'pertanyaan' => 'Di mana lokasi pengambilan barang? Apakah bisa dikirim?',
                'jawaban'    => 'Lokasi pengambilan barang kami berada di Jl. Veteran, Kec. Lowokwaru, Malang kota. Kami juga menyediakan layanan pengiriman untuk area Malang Kota dan sekitarnya dengan biaya tambahan yang disesuaikan dengan jarak pengiriman.',
            ],
            [
                'pertanyaan' => 'Apa yang terjadi jika alat rusak atau terlambat dikembalikan?',
                'jawaban'    => 'Untuk kerusakan ringan akibat penggunaan normal, tidak dikenakan biaya tambahan. Namun untuk kerusakan berat, akan ada biaya perbaikan atau penggantian sesuai perjanjian. Keterlambatan pengembalian dikenakan biaya sewa harian tambahan.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['pertanyaan' => $faq['pertanyaan']],
                array_merge($faq, ['id_admin' => $adminId])
            );
        }
    }
}
