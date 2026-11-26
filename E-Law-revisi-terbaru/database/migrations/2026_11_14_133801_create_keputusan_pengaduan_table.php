
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keputusan_pengaduan', function (Blueprint $table) {
            $table->id('id_keputusan');
            $table->unsignedBigInteger('id_pengaduan');
            $table->unsignedBigInteger('id_pimpinan');
            $table->string('status_keputusan');
            $table->text('catatan_arahan')->nullable();
            $table->date('tanggal_keputusan');

            $table->foreign('id_pengaduan')
                ->references('id_pengaduan')
                ->on('pengaduan')
                ->onDelete('cascade');

            $table->foreign('id_pimpinan')
                ->references('id_pengguna')
                ->on('pengguna')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keputusan_pengaduan');
    }
};
