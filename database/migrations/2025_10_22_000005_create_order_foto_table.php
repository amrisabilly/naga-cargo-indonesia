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
        Schema::create('order_foto', function (Blueprint $table) {
            $table->id('id_foto');
            $table->string('AWB', 30);
            $table->string('path_foto', 255);
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->string('keterangan', 100)->nullable();
            $table->foreign('AWB')->references('AWB')->on('order')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('order_foto');
    }
};