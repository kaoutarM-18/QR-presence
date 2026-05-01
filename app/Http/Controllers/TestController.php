<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            return "OK - User: " . ($user ? $user->name : 'No user');
        } catch (\Exception $e) {
            return "ERROR: " . $e->getMessage() . " in " . $e->getFile() . " line " . $e->getLine();
        }
    }
}