<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Controllers\Controller\AlunoController;
use App\Models\Aluno;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(rules: [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'numIdentidade' => 'required|string|unique:users|max:20',
            'funcao' => 'required|in:administrador,professor,aluno',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numIdentidade' => $request->numIdentidade,
            'funcao' => $request->funcao,
        ]);
        event(new Registered($user));

        Auth::login($user);
        
        // Se for aluno, cria o registro na tabela alunos
        if ($user->funcao === \App\Enums\FuncaoEnum::ALUNO) {
            Aluno::create([
                'user_id' => $user->id, 
                'idTurma' => null,
                'dataIngresso' => now(),
                'dataConclusao' => null,
                'statusDeConclusao' => 'em andamento',
                'pontosRecebidos' => 0,
            ]);
            return redirect()->route('aluno.edit', ['numIdentidade' => $user->numIdentidade]);

        }



        return redirect(route('dashboard', absolute: false));
    }

}
