<?php

namespace App\Http\Controllers;

use App\Models\AtividadeComplementar;
use Illuminate\Http\Request;

class AtividadeComplementarController extends Controller
{
    public function index()
    {
        return AtividadeComplementar::with('tipoAtividade')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string',
            'nomeAtividadeComplementar' => 'required|string',
            'maximoSemestral' => 'required|integer',
            'idTipoAtividade' => 'required|exists:tipo_atividades,id',
        ]);

        return AtividadeComplementar::create($request->all());
    }

    public function show($id)
    {
        return AtividadeComplementar::with('tipoAtividade')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $atividade = AtividadeComplementar::findOrFail($id);
        $atividade->update($request->all());
        return $atividade;
    }

    public function destroy($id)
    {
        return AtividadeComplementar::destroy($id);
    }
}

