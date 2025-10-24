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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->enum('role', ['Kurir', 'PIC']);
            $table->string('nama', 100);
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('no_hp', 255);
            $table->foreignId('id_daerah')->nullable()->constrained('daerah', 'id_daerah')->cascadeOnUpdate()->nullOnDelete();
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
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
        Schema::dropIfExists('user');
    }
};