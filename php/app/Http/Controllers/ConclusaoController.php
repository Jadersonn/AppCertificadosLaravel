<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConclusaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'curso' => 'required|string|max:255',
            'turno' => 'required|in:Matutino,Vespertino,Noturno,Integral',
            'ano_ingresso' => 'required|string|max:10',
            'ano_conclusao' => 'required|string|max:10',
        ]);

        $conclusao = \App\Models\Conclusao::create([
            'curso' => $request->curso,
            'turno' => $request->turno,
            'ano_ingresso' => $request->ano_ingresso,
            'ano_conclusao' => $request->ano_conclusao,
            'idAluno' => Auth::user()->aluno->idAluno,
            'preenchido' => true
        ]);

        return redirect()->back()->with('success', 'Informações de conclusão salvas com sucesso!');
    }
}
