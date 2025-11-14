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
            $table->string('id_PIC')->nullable()->constrained('users', 'id_user')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('id_daerah')->nullable()->constrained('daerah', 'id_daerah')->cascadeOnUpdate()->nullOnDelete();
            $table->string('tujuan', 255)->nullable()->default(null);
            $table->string('penerima', 50)->nullable()->default(null);
            $table->string('no_hp', 255)->nullable()->default(null);
            $table->date('tanggal')->nullable()->default(null);
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