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
        Schema::create('atividades_complementares', function (Blueprint $table) {
            $table->id('idAtividadeComplementar');
            $table->string('descricaoAtividadeComplementar');
            $table->string('nomeAtividadeComplementar');
            $table->integer('maximoSemestralAtividadeComplementar')->default(0);
            $table->foreignId('idTipoAtividade')
                ->constrained('tipos_atividades', 'idTipoAtividade')
                ->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades_complementares');
        Schema::table('atividades_complementares', function (Blueprint $table) {
            $table->dropForeign(['idTipoAtividade']);
        });
    }
};
