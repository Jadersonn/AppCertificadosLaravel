<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index()
    {
        return Turma::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string',
        ]);

        return Turma::create($request->all());
    }

    public function show($id)
    {
        return Turma::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $turma = Turma::findOrFail($id);
        $turma->update($request->all());
        return $turma;
    }

    public function destroy($id)
    {
        return Turma::destroy($id);
    }

    public function adicionarAlunos(Request $request)
    {
        $turma = Turma::findOrFail($request->input('turma_id'));
        $alunos = $request->input('alunos', []);

        foreach ($alunos as $alunoId) {
            $turma->alunos()->attach($alunoId);
        }

        return redirect()->back()->with('success', 'Alunos adicionados à turma com sucesso.');
    }
}
