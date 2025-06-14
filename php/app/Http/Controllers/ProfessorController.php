<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        return Professor::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        return Professor::create([
            'user_id' => $request->user_id,
        ]);
    }

    public function show($numIdentidade)
    {
        // Valida o numero de identidade
        $professor = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o aluno foi encontrado
        if (!$professor) {
            abort(404, 'Professor não encontrado');
        }
        // Verifica se o usuário autenticado é professor. Se for outro tipo, impede o acesso.
        if ($professor->user->funcao !== \App\Enums\FuncaoEnum::PROFESSOR ) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('professor.professor', compact('professor'));
    }

    public function showAdmin($numIdentidade)
    {
        // Valida o numero de identidade
        $administrador = Professor::with('user')->whereHas('user', function ($query) use ($numIdentidade) {
            $query->where('numIdentidade', $numIdentidade);
        })->first();

        // Verifica se o aluno foi encontrado
        if (!$administrador) {
            abort(404, 'Administrador não encontrado');
        }
        // Verifica se o usuário autenticado é administrador. Se for outro tipo, impede o acesso.
        if ($administrador->user->funcao !== \App\Enums\FuncaoEnum::ADMINISTRADOR ) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('administrador.administrador', compact('administrador'));
    }

    public function update(Request $request, $id)
    {
        $professor = Professor::findOrFail($id);
        $professor->update($request->all());
        return $professor;
    }

    public function destroy($user_id)
    {
        return Professor::destroy($user_id);
    }
}

