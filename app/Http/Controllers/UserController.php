<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('avatar')) {
            $imageName = $request->file('avatar')->getClientOriginalName();
            $request->avatar->move(public_path('storage/img'), $imageName);

            $input['avatar'] = $imageName;
        }

        $user = User::create($input);

        return redirect()->route('users.show', $user)->with('success', 'Użytkownik został pomyślnie dodany.');
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();

        if (empty($input['password'])) {
            unset($input['password']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        if ($request->hasFile('avatar')) {
            $imageName = $request->file('avatar')->getClientOriginalName();
            $request->avatar->move(public_path('storage/img'), $imageName);
            $input['avatar'] = $imageName;
        }

        $user->update($input);

        return redirect()->route('users.show', $user)->with('success', 'Użytkownik został pomyślnie zaktualizowany.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('index')->with('success', 'Użytkownik został pomyślnie usunięty.');
    }
}
