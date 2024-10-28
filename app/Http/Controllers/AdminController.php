<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{

    public function userManagement()
    {
        $users = User::select('id', 'name', 'email')->get();
        
        return view('admin.user-management', compact('users'));
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Função para editar um utilizador
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Função para apagar um utilizador
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user-management')->with('success', 'Utilizador apagado com sucesso.');
    }
}
