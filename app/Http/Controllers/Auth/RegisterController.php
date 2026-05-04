<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $filieres = Filiere::all();

       return view('auth.register', compact('filieres'));

    }

    public function register(Request $request)
    {
       $request->validate([
            'nom'        => 'required|string|max:255',
            'prenom'     => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6|confirmed',
            'role'       => 'required|in:enseignant,etudiant',
            'filiere_id' => 'required_if:role,etudiant',
        ]);

       $user = User::create([
            'nom'     => $request->nom,
            'prenom'  => $request->prenom,
            'email'   => $request->email,
            'password'=> Hash::make($request->password),
            'role'    => $request->role,
        ]);

        if ($user->role === 'etudiant') {
            \App\Models\Etudiant::create([
                'user_id'   => $user->id,
                'filiere_id'=> $request->filiere_id ?? null,
            ]);
        }
        
        if ($user->role === 'enseignant') {
            \App\Models\Professeur::create([
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

        if ($user->role === 'enseignant') {
            return redirect()->route('enseignant.dashboard');
        }

        return redirect()->route('etudiant.dashboard');
    }
}