
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_tim_hukum', function (Blueprint $table) {
            $table->id('id_penugasan');
            $table->unsignedBigInteger('id_pengaduan');
            $table->unsignedBigInteger('id_tim_hukum');
            $table->string('kategori_akhir');
            $table->date('tanggal_penyerahan');
            $table->string('status_penugasan')->default('Ditugaskan');

            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduan')
                  ->onDelete('cascade');

            $table->foreign('id_tim_hukum')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_tim_hukum');
    }
};
