<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;

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

        Turma::create($request->all());

        return redirect()->back()->with('success', 'Turma criada com sucesso!');
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
        Turma::destroy($id);
        return redirect()->back()->with('success', 'Turma deletada com sucesso!');
    }

    public function adicionarAlunos(Request $request)
    {
        $turma = Turma::findOrFail($request->input('turma_id'));
        $alunos = $request->input('alunos', []);

        foreach ($alunos as $alunoId) {
            Aluno::where('idAluno', $alunoId)->update(['idTurma' => $turma->getKey()]);
        }

        return redirect()->back()->with('success', 'Alunos adicionados à turma com sucesso.');
    }

    public function relatorioTurma(Request $request, $id)
    {
        $turma = Turma::findOrFail($id);
        $alunos = DB::table('alunos')
            ->join('users', 'alunos.user_id', '=', 'users.id')
            ->select([
                'users.name',
                'users.email',
                'users.numIdentidade',
                'alunos.statusDeConclusao',
                'alunos.idAluno'
            ])
            ->where('alunos.idTurma', $turma->id)
            ->get();

        return view('relatorio.relatorioBuscaTurma', compact('turma', 'alunos'));
    }
}
