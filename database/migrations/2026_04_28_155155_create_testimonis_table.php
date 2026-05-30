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
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id('id_testimoni');
            $table->string('nama_customer', 150);
            $table->string('foto_customer')->nullable();
            $table->tinyInteger('rating')->unsigned()->default(0);
            $table->text('isi_review');
            $table->foreignId('id_admin')
                  ->nullable()
                  ->constrained('admins', 'id_admin')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
