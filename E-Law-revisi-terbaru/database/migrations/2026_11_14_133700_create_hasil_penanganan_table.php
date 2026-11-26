
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_penanganan', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->unsignedBigInteger('id_pengaduan');
            $table->unsignedBigInteger('id_tim_hukum');
            $table->text('hasil_analisis');
            $table->text('rekomendasi_penanganan');
            $table->date('tanggal_penyusunan');

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
        Schema::dropIfExists('hasil_penanganan');
    }
};
