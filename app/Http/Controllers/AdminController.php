<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('admin.index');
        }

        return redirect('/')->withErrors('Niestety, nie masz uprawnień do tej strony.');
    }
}
