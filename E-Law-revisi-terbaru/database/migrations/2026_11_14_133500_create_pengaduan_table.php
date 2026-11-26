
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nomor_pengaduan')->unique();
            $table->unsignedBigInteger('id_mahasiswa');
            $table->string('kategori');
            $table->string('judul_pengaduan');
            $table->text('informasi_permasalahan')->nullable();
            $table->text('kronologi');
            $table->date('tanggal_pengajuan');
            $table->string('status')->default('Diajukan');

            $table->foreign('id_mahasiswa')
                ->references('id_mahasiswa')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
