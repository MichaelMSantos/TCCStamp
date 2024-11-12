<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        // Validação e autenticação do usuário
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            session()->flash('sucesso', 'Bem-vindo de volta!');
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('home'))->with('deslogado', 'Sessão encerrada com sucesso');
    }
}
