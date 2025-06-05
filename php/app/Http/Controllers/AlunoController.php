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
        $user = Aluno::with('user')->where('numIdentidade', $numIdentidade)->first();

        if ($user->numIdentidade !== $numIdentidade) {
            abort(403, 'Acesso negado'); // Bloqueia se não for o próprio aluno
        }

        return view('aluno.show', compact('user'));
    }

    public function update(Request $request, $id){
        $aluno = Aluno::findOrFail($id);
        $aluno->update($request->all());
        return $aluno;
    }

    public function destroy($id)
    {
        return Aluno::destroy($id);
    }
}

