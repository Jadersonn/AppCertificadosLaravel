<?php

namespace App\Http\Controllers;

use App\Models\TipoAtividade;
use Illuminate\Http\Request;

class TipoAtividadeController extends Controller
{
    public function index()
    {
        return TipoAtividade::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'maximoSemestral' => 'required|integer',
        ]);

        return TipoAtividade::create($request->all());
    }

    public function show($id)
    {
        return TipoAtividade::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoAtividade::findOrFail($id);
        $tipo->update($request->all());
        return $tipo;
    }

    public function destroy($id)
    {
        return TipoAtividade::destroy($id);
    }
}

