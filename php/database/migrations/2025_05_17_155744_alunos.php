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
            $table->foreignId('idTurma')->nullable()->constrained('turmas')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
