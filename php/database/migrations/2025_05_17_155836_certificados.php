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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('idAluno')
                ->constrained('alunos', 'idAluno')
                ->onDelete('cascade');

            $table->foreignId('idAtividadeComplementar')
                ->constrained('atividades_complementares', 'idAtividadeComplementar')
                ->onDelete('cascade');

            $table->date('dataEnvio');
            $table->string('statusCertificado');
            $table->string('justificativa')->nullable();
            $table->string('caminhoArquivo');
            $table->double('cargaHoraria');
            $table->string('semestre');

            $table->foreignId('idProfessor')
                ->nullable()
                ->constrained('professores', 'idProfessor')
                ->onDelete('set null');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
        Schema::table('certificados', function (Blueprint $table) {
            $table->dropForeign(['idAluno']);
            $table->dropForeign(['idAtividadeComplementar']);
            $table->dropForeign(['idProfessor']);
        });
    }
};
