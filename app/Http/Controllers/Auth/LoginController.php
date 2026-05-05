<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        // juste le userName valide est admin ou bien un email
        if ($request->email !== 'ENSIASD' && !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
        return back()->withErrors([
            'email' => 'Email invalide',
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            

        // redirection selon le role :    
            if (Auth::user()->role === 'enseignant') {
                return redirect()->route('enseignant.dashboard');
            }
            return redirect()->route('etudiant.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    // fonction de log out
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}