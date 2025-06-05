<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        return Aluno::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'dataIngresso' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'idTurma' => 'required|exists:turmas,id',
        ]);

        return Aluno::create($request->all());
    }

    public function show($numIdentidade)
    {
        // Valida o numero de identidade
        $aluno = Aluno::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o aluno foi encontrado
        if (!$aluno) {
            abort(404, 'Aluno não encontrado');
        }

        return view('aluno.show', compact('aluno'));
    }

    public function update(Request $request, $id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());
        return $aluno;
    }

    public function destroy($id)
    {
        return Aluno::destroy($id);
    }
}

