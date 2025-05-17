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
            'idUsuario' => 'required|exists:users,id',
            'idTurma' => 'required|exists:turmas,id',
        ]);

        return Aluno::create($request->all());
    }

    public function show($id)
    {
        return Aluno::with('user')->findOrFail($id);
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

