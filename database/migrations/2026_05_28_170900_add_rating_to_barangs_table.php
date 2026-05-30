<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(0)->after('is_aktif');
            $table->unsignedInteger('jumlah_review')->default(0)->after('rating');
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['rating', 'jumlah_review']);
        });
    }
};
