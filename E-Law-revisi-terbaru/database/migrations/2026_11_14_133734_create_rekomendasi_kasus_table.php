
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekomendasi_kasus', function (Blueprint $table) {
            $table->id('id_rekomendasi');
            $table->unsignedBigInteger('id_pengaduan');
            $table->text('isi_rekomendasi');
            $table->date('tanggal_rekomendasi');

            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_kasus');
    }
};
