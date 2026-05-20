<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('nama_paket', 200);
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('items'); // JSON array of included items
            $table->decimal('harga', 12, 2);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};
