<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->unsignedInteger('id_persona')->unique();
            $table->string('username', 50)->unique();
            $table->text('password_hash');
            $table->timestamp('ultimo_login')->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamp('creado_en')->useCurrent();

            $table->foreign('id_persona')->references('id_persona')->on('personas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
