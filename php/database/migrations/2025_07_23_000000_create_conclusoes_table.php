<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConclusoesTable extends Migration
{
    public function up()
    {
        Schema::create('conclusoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAluno');
            $table->string('curso');
            $table->string('turno');
            $table->string('ano_ingresso');
            $table->string('ano_conclusao');
            $table->boolean('preenchido')->default(false);
            $table->date('dataConclusao')->nullable();
            $table->string('status')->default('pendente');
            $table->text('observacao')->nullable();
            $table->timestamps();

            $table->foreign('idAluno')
                  ->references('idAluno')->on('alunos')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('conclusoes', function (Blueprint $table) {
            $table->dropForeign(['idAluno']);
        });
        Schema::dropIfExists('conclusoes');
    }
}