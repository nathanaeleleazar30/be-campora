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
        Schema::create('ketersediaan_barangs', function (Blueprint $table) {
            $table->id('id_ketersediaan');
            $table->foreignId('id_barang')
                  ->constrained('barangs', 'id_barang')
                  ->cascadeOnDelete();
            $table->foreignId('id_admin')
                  ->constrained('admins', 'id_admin')
                  ->restrictOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedInteger('stok_disewa');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Ensure tanggal_mulai is always before tanggal_selesai (enforced at app layer)
            $table->index(['id_barang', 'tanggal_mulai', 'tanggal_selesai'], 'idx_ketersediaan_barang_tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketersediaan_barangs');
    }
};
