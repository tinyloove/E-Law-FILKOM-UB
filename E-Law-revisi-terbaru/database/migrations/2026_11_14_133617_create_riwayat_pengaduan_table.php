
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pengaduan', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_pengaduan');
            $table->string('aktivitas');
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_baru');
            $table->text('keterangan')->nullable();
            $table->dateTime('waktu_perubahan');

            $table->foreign('id_pengaduan')
                  ->references('id_pengaduan')
                  ->on('pengaduan')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengaduan');
    }
};
