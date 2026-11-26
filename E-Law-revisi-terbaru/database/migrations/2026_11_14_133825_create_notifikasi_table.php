
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_pengaduan');
            $table->text('isi_notifikasi');
            $table->dateTime('waktu_dibuat');
            $table->string('status_notifikasi')->default('Belum Dibaca');

            $table->foreign('id_pengguna')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');

            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
