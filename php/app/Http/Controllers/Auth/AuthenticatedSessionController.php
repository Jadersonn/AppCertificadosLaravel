<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        // pegando o usuario autenticado
        $user = Auth::user();

        // verificando o tipo de usuario e apontando para a pagina correspondente
        if ($user->funcao === \App\Enums\FuncaoEnum::ADMINISTRADOR) {
            return redirect()->route('administrador');
        } elseif ($user->funcao === \App\Enums\FuncaoEnum::PROFESSOR) {
            return redirect()->route('professor');
        } elseif ($user->funcao === \App\Enums\FuncaoEnum::ALUNO) {
            return redirect()->route('aluno');
        }
        // caso nao tenha um papel definido, redirecione para a página principal
        return redirect()->route('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
