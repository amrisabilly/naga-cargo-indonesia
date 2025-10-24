<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->string('AWB', 30)->primary();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_daerah')->nullable()->constrained('daerah', 'id_daerah')->cascadeOnUpdate()->nullOnDelete();
            $table->string('tujuan', 70)->nullable();
            $table->string('penerima', 50)->nullable();
            $table->string('no_hp', 255)->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('status', ['Proses', 'Gagal', 'Terkirim'])->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};