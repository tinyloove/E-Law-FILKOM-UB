
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_pengaduan', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->unsignedBigInteger('id_pengaduan');
            $table->string('nama_file');
            $table->string('lokasi_file');
            $table->dateTime('tanggal_upload');

            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_pengaduan');
    }
};