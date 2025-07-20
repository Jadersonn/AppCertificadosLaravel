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
use App\Models\Professor;

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
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'numIdentidade' => $request->input('numIdentidade'),
            'funcao' => $request->input('funcao'),
        ]);
        event(new Registered($user));

        Auth::login($user);
        
        // Se for aluno, cria o registro na tabela alunos
        if ($user->funcao === \App\Enums\FuncaoEnum::ALUNO) {
            Aluno::create([
                'user_id' => $user->input('id'), 
                'idTurma' => null,
                'dataIngresso' => now(),
                'dataConclusao' => null,
                'statusDeConclusao' => 'em andamento',
                'pontosRecebidos' => 0,
            ]);
            return redirect()->route('aluno', ['numIdentidade' => $user->numIdentidade]);

        }

        //se for professor or admin, redireciona para a rota correspondente 
        if ($user->funcao === \App\Enums\FuncaoEnum::PROFESSOR) {
            Professor::create([
                'user_id' => $user->input('id'),
            ]);
            return redirect()->route('professor');
        } elseif ($user->funcao === \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            Professor::create([
                'user_id' => $user->input('id'),
            ]);
            return redirect()->route('administrador');
        }


        return redirect(route('dashboard', absolute: false));
    }

    // Exibe o formulário de registro para aluno, já preenchendo idTurma
    public function createAluno($idSala)
    {
        return view('auth.register', [
            'tipoCadastro' => 'aluno',
            'idSala' => $idSala,
        ]);
    }

    // Salva o aluno
    public function storeAluno(Request $request)
    {
        $request->merge(['funcao' => 'aluno']); // força a função aluno
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'numIdentidade' => 'required|string|unique:users|max:20',
            'idSala' => 'required|exists:turmas,id',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'numIdentidade' => $request->input('numIdentidade'),
            'funcao' => 'aluno',
        ]);
        event(new Registered($user));

        Auth::login($user);

        Aluno::create([
            'user_id' => $user->getKey(),
            'idTurma' => $request->input('idSala'),
            'dataIngresso' => now(),
            'dataConclusao' => null,
            'statusDeConclusao' => 'em andamento',
            'pontosRecebidos' => 0,
        ]);

        return redirect()->route('aluno', ['numIdentidade' => $user->numIdentidade]);
    }

    // Exibe o formulário de registro para professor
    public function createProfessor()
    {
        return view('auth.register', [
            'tipoCadastro' => 'professor',
        ]);
    }

    // Salva o professor
    public function storeProfessor(Request $request)
    {
        $request->merge(['funcao' => 'professor-E']); // força a função professor
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'numIdentidade' => 'required|string|unique:users|max:20',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'numIdentidade' => $request->input('numIdentidade'),
            'funcao' => 'professor-E',
        ]);
        event(new Registered($user));

        Auth::login($user);

        Professor::create([
            'user_id' => $user->getKey(),
        ]);

        return redirect()->route('/')->with('status', 'Professor registrado com sucesso!');
    }

}
