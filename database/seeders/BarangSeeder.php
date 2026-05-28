<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\FotoBarang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Seed semua 20 barang dari frontend products.ts ke database backend.
     * Mapping kategori dilakukan berdasarkan nama kategori yang sudah di-seed.
     */
    public function run(): void
    {
        // Ambil mapping kategori
        $kategoris = KategoriBarang::pluck('id_kategori', 'nama_kategori');

        $barangs = [
            // ── Tenda ──────────────────────────────────────────────────────
            [
                'nama_barang'    => 'Tenda 2 Orang',
                'kategori'       => 'Tenda',
                'harga_per_hari' => 29000,
                'merk'           => 'Consina',
                'spesifikasi'    => "Tenda ringan kapasitas 2 orang, mudah dibawa dan dipasang.\n\nFitur:\n- Kapasitas 2 Orang\n- Waterproof\n- Ringan & Kompak\n- Mudah Dipasang",
                'stok_total'     => 8,
            ],
            [
                'nama_barang'    => 'Tenda Family 8 Orang',
                'kategori'       => 'Tenda',
                'harga_per_hari' => 66000,
                'merk'           => 'Eiger',
                'spesifikasi'    => "Tenda luas untuk keluarga besar, kapasitas hingga 8 orang.\n\nFitur:\n- Kapasitas 8 Orang\n- Dua Pintu\n- Ventilasi Baik\n- Waterproof",
                'stok_total'     => 4,
            ],
            [
                'nama_barang'    => 'Tenda Family 4 Orang',
                'kategori'       => 'Tenda',
                'harga_per_hari' => 45000,
                'merk'           => 'Quechua',
                'spesifikasi'    => "Tenda keluarga 4 orang dengan ruang yang luas dan nyaman.\n\nFitur:\n- Kapasitas 4 Orang\n- Easy Setup\n- Waterproof\n- Mesh Ventilation",
                'stok_total'     => 6,
            ],
            [
                'nama_barang'    => 'Tenda 8 Orang',
                'kategori'       => 'Tenda',
                'harga_per_hari' => 35000,
                'merk'           => 'Naturehike',
                'spesifikasi'    => "Tenda besar 8 orang cocok untuk camping keluarga besar.\n\nFitur:\n- Kapasitas 8 Orang\n- Dome Style\n- Waterproof\n- Carrying Bag",
                'stok_total'     => 3,
            ],

            // ── Carrier ────────────────────────────────────────────────────
            [
                'nama_barang'    => 'Carrier Bag 40L',
                'kategori'       => 'Carrier',
                'harga_per_hari' => 35000,
                'merk'           => 'Deuter',
                'spesifikasi'    => "Tas carrier 40 liter cocok untuk pendakian 2-3 hari.\n\nFitur:\n- 40 Liter\n- Hip Belt\n- Rain Cover\n- Multiple Compartments",
                'stok_total'     => 10,
            ],
            [
                'nama_barang'    => 'Carrier 80L',
                'kategori'       => 'Carrier',
                'harga_per_hari' => 75000,
                'merk'           => 'Osprey',
                'spesifikasi'    => "Carrier besar 80L untuk ekspedisi panjang dan beban berat.\n\nFitur:\n- 80 Liter\n- Frame Aluminium\n- Load Lifter\n- Rain Cover Included",
                'stok_total'     => 5,
            ],
            [
                'nama_barang'    => 'Carrier Bag 60L',
                'kategori'       => 'Carrier',
                'harga_per_hari' => 40000,
                'merk'           => 'Gregory',
                'spesifikasi'    => "Carrier 60L ideal untuk pendakian multi-hari.\n\nFitur:\n- 60 Liter\n- Ergonomic Back\n- Side Pockets\n- Hydration Compatible",
                'stok_total'     => 7,
            ],
            [
                'nama_barang'    => 'Carrier Bag 20L',
                'kategori'       => 'Carrier',
                'harga_per_hari' => 20000,
                'merk'           => 'Deuter',
                'spesifikasi'    => "Daypack 20L ringan untuk hiking sehari.\n\nFitur:\n- 20 Liter\n- Hydration Pocket\n- Lightweight\n- Breathable Back",
                'stok_total'     => 12,
            ],

            // ── Sleeping Bag ───────────────────────────────────────────────
            [
                'nama_barang'    => 'Sleeping Bag Pillow',
                'kategori'       => 'Sleeping Bag',
                'harga_per_hari' => 25000,
                'merk'           => 'Handar',
                'spesifikasi'    => "Sleeping bag nyaman untuk suhu -5°C hingga 10°C.\n\nFitur:\n- Suhu -5°C - 10°C\n- Lightweight\n- Compact\n- Zipper Dua Arah",
                'stok_total'     => 15,
            ],
            [
                'nama_barang'    => 'Sleeping Bag Big',
                'kategori'       => 'Sleeping Bag',
                'harga_per_hari' => 45000,
                'merk'           => 'Mountain Hardwear',
                'spesifikasi'    => "Sleeping bag mummy untuk pendakian ekstrem.\n\nFitur:\n- Mummy Shape\n- Suhu -10°C\n- Down Insulation\n- Kompak",
                'stok_total'     => 6,
            ],
            [
                'nama_barang'    => 'Sleeping Bag Standar',
                'kategori'       => 'Sleeping Bag',
                'harga_per_hari' => 15000,
                'merk'           => 'Consina',
                'spesifikasi'    => "Sleeping bag standar untuk suhu 5°C hingga 15°C.\n\nFitur:\n- Suhu 5°C - 15°C\n- Rectangular Shape\n- Soft Lining\n- Machine Washable",
                'stok_total'     => 20,
            ],

            // ── Perlengkapan ───────────────────────────────────────────────
            [
                'nama_barang'    => 'Head Lamp',
                'kategori'       => 'Perlengkapan',
                'harga_per_hari' => 10000,
                'merk'           => 'Black Diamond',
                'spesifikasi'    => "Lampu kepala LED terang untuk penerangan malam hari.\n\nFitur:\n- LED Terang\n- Tahan Air\n- Baterai Tahan Lama\n- Adjustable Strap",
                'stok_total'     => 25,
            ],
            [
                'nama_barang'    => 'Cooking Set',
                'kategori'       => 'Perlengkapan',
                'harga_per_hari' => 50000,
                'merk'           => 'Snow Peak',
                'spesifikasi'    => "Set peralatan memasak lengkap untuk camping di alam terbuka.\n\nFitur:\n- 5 Pieces Set\n- Non-Stick\n- Compact Storage\n- Anti-Gores",
                'stok_total'     => 8,
            ],
            [
                'nama_barang'    => 'Trekking Pole',
                'kategori'       => 'Perlengkapan',
                'harga_per_hari' => 10000,
                'merk'           => 'Black Diamond',
                'spesifikasi'    => "Trekking pole aluminium ringan dan kuat untuk pendakian.\n\nFitur:\n- Aluminium\n- Adjustable Height\n- Cork Handle\n- Wrist Strap",
                'stok_total'     => 18,
            ],
            [
                'nama_barang'    => 'Cooking Set Portable',
                'kategori'       => 'Perlengkapan',
                'harga_per_hari' => 35000,
                'merk'           => 'MSR',
                'spesifikasi'    => "Set memasak portabel ringan untuk pendakian.\n\nFitur:\n- Titanium Material\n- Lightweight\n- 3 Pieces\n- Compact",
                'stok_total'     => 6,
            ],

            // ── Pakaian ────────────────────────────────────────────────────
            [
                'nama_barang'    => 'Jacket Gunung',
                'kategori'       => 'Pakaian',
                'harga_per_hari' => 20000,
                'merk'           => 'The North Face',
                'spesifikasi'    => "Jaket gunung anti angin dan air untuk pendakian.\n\nFitur:\n- Anti Angin\n- Waterproof\n- Ringan\n- Pockets",
                'stok_total'     => 12,
            ],
            [
                'nama_barang'    => 'Snow Jacket',
                'kategori'       => 'Pakaian',
                'harga_per_hari' => 30000,
                'merk'           => 'Columbia',
                'spesifikasi'    => "Jaket tebal untuk suhu sangat dingin dan salju.\n\nFitur:\n- Insulated\n- Waterproof\n- Hood\n- Warm Lining",
                'stok_total'     => 8,
            ],
            [
                'nama_barang'    => 'Jacket Outdoor',
                'kategori'       => 'Pakaian',
                'harga_per_hari' => 25000,
                'merk'           => 'Patagonia',
                'spesifikasi'    => "Jaket outdoor serbaguna untuk berbagai aktivitas luar ruang.\n\nFitur:\n- Breathable\n- Wind Resistant\n- Packable\n- Lightweight",
                'stok_total'     => 10,
            ],
            [
                'nama_barang'    => 'Jacket Gunung Premium',
                'kategori'       => 'Pakaian',
                'harga_per_hari' => 25000,
                'merk'           => "Arc'teryx",
                'spesifikasi'    => "Jaket gunung premium dengan teknologi terkini.\n\nFitur:\n- Gore-Tex\n- Waterproof\n- Breathable\n- Seam Sealed",
                'stok_total'     => 5,
            ],

            // ── Sepatu ─────────────────────────────────────────────────────
            [
                'nama_barang'    => 'Sepatu Hiking',
                'kategori'       => 'Sepatu',
                'harga_per_hari' => 30000,
                'merk'           => 'Salomon',
                'spesifikasi'    => "Sepatu hiking waterproof dengan grip anti-slip.\n\nFitur:\n- Waterproof\n- Anti-Slip Sole\n- Ankle Support\n- Breathable",
                'stok_total'     => 10,
            ],
        ];

        $fotoMapping = [
            'Tenda 2 Orang' => 'tenda 2 orang.png',
            'Head Lamp' => 'head lamp.png',
            'Tenda Family 8 Orang' => 'tenda 8 orang.png',
            'Jacket Gunung' => 'jacket gunung.png',
            'Snow Jacket' => 'snow jacket.png',
            'Carrier Bag 40L' => 'carrier bag 40L.png',
            'Tenda Family 4 Orang' => 'tenda family 4 orang.png',
            'Jacket Outdoor' => 'jacket outdoor.png',
            'Jacket Gunung Premium' => 'jacket gunung orange.png',
            'Sleeping Bag Pillow' => 'sleeping bag standar.png',
            'Sepatu Hiking' => 'sepatu hiking solomon.png',
            'Carrier 80L' => 'carrier 80L.png',
            'Sleeping Bag Big' => 'sleeping bag big.png',
            'Carrier Bag 60L' => 'carrier bag 60L.png',
            'Cooking Set' => 'cooking set.png',
            'Trekking Pole' => 'trekking pole.png',
            'Tenda 8 Orang' => 'tenda 8 orang.png',
            'Cooking Set Portable' => 'cooking set.png',
            'Carrier Bag 20L' => 'carrier bag 20L.png',
            'Sleeping Bag Standar' => 'sleeping bag standar putih.png',
        ];

        foreach ($barangs as $data) {
            $kategoriName = $data['kategori'];
            unset($data['kategori']);

            $idKategori = $kategoris[$kategoriName] ?? null;
            if (!$idKategori) {
                $this->command->warn("Kategori '{$kategoriName}' tidak ditemukan, skip: {$data['nama_barang']}");
                continue;
            }

            $barang = Barang::updateOrCreate(
                ['nama_barang' => $data['nama_barang']],
                array_merge($data, [
                    'id_kategori' => $idKategori,
                    'is_aktif'    => true,
                ])
            );

            // Seed Foto Barang jika ada di mapping
            if (isset($fotoMapping[$barang->nama_barang])) {
                FotoBarang::updateOrCreate(
                    [
                        'id_barang' => $barang->id_barang,
                        'url_foto'  => '/images/' . $fotoMapping[$barang->nama_barang]
                    ]
                );
            }
        }
    }
}
