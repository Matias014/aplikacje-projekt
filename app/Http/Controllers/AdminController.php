<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->role == 'admin') {
            return view('admin.index');
        }
        return redirect('/')->withErrors('Niestety, nie masz uprawnień do tej strony.');
    }

    // public function show(User $user)
    // {
    //     return view('admin.users.show_user', ['user' => $user]);
    // }

    // public function edit(User $user)
    // {
    //     return view('admin.users.edit', ['user' => $user]);
    // }

    // public function create()
    // {
    //     return view('admin.user.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string|max:20|unique:users',
    //         'name' => 'required|string|max:20',
    //         'surname' => 'required|string|max:25',
    //         'email' => 'required|string|email|max:60|unique:users',
    //         'password' => 'required|string|max:100|confirmed',
    //         'avatar' => 'nullable|string|max:40',
    //     ]);

    //     User::create([
    //         'username' => $request->username,
    //         'name' => $request->name,
    //         'surname' => $request->surname,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'avatar' => $request->avatar,
    //     ]);

    //     return redirect()->route('admin.users.index')->with('success', 'Użytkownik został pomyślnie dodany.');
    // }

    // public function update(Request $request, User $user)
    // {
    //     $request->validate([
    //         'username' => 'required|string|max:255',
    //         'name' => 'required|string|max:255',
    //         'surname' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'avatar' => 'nullable|string|max:255',
    //     ]);

    //     $user->update([
    //         'username' => $request->username,
    //         'name' => $request->name,
    //         'surname' => $request->surname,
    //         'email' => $request->email,
    //         'password' => $request->password ? Hash::make($request->password) : $user->password,
    //         'avatar' => $request->avatar,
    //     ]);

    //     return redirect()->route('admin.users.index')->with('success', 'Użytkownik został pomyślnie zaktualizowany.');
    // }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return redirect()->route('admin.users.index')->with('success', 'Użytkownik został pomyślnie usunięty.');
    // }
}
