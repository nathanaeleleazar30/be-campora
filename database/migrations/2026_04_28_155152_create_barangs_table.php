<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('id_barang');
            $table->foreignId('id_kategori')
                  ->constrained('kategori_barangs', 'id_kategori')
                  ->cascadeOnDelete();
            $table->string('nama_barang', 200);
            $table->string('merk', 100)->nullable();
            $table->text('spesifikasi')->nullable();
            $table->decimal('harga_per_hari', 12, 2);
            $table->unsignedInteger('stok_total')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
