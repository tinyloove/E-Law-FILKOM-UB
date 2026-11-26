
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_log', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_pengguna');
            $table->dateTime('waktu_login');
            $table->string('ip_address')->nullable();
            $table->string('status');

            $table->foreign('id_pengguna')
                  ->references('id_pengguna')
                  ->on('pengguna')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_log');
    }
};
