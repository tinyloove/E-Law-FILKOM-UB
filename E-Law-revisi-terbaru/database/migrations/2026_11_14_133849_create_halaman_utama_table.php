
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halaman_utama', function (Blueprint $table) {
            $table->id('id_halaman');
            $table->string('nama_halaman');
            $table->text('deskripsi')->nullable();

            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')
                  ->references('id_role')
                  ->on('roles')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halaman_utama');
    }
};
