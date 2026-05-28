<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {
            $table->string('produk_disewa', 200)->nullable()->after('isi_review');
            $table->string('kegiatan', 200)->nullable()->after('produk_disewa');
        });
    }

    public function down(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {
            $table->dropColumn(['produk_disewa', 'kegiatan']);
        });
    }
};
