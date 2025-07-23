<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('atividades_complementares', function (Blueprint $table) {
            $table->decimal('indice', 2, 1)->nullable()->after('idTipoAtividade');
        });
    }

    public function down()
    {
        Schema::table('atividades_complementares', function (Blueprint $table) {
            $table->dropColumn('indice');
        });
    }
};
