<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id('idAluno');
            $table->date('dataIngresso');
            $table->date('dataConclusao')->nullable();
            $table->string('statusDeConclusao');
            $table->double('pontosRecebidos')->default(0);

            $table->foreignId('idUsuario')
                ->constrained('usuarios', 'idUsuario')
                ->onDelete('cascade');

            $table->foreignId('idTurma')
                ->constrained('turmas', 'idTurma')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
        Schema::table('alunos', function (Blueprint $table) {
            $table->dropForeign(['idUsuario']);
            $table->dropForeign(['idTurma']);
        });
    }
};
