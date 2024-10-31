<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Problem;



use App\Models\User;

class AdminController extends Controller
{

    public function userManagement()
    {
        $users = User::select('id', 'name', 'email', 'usertype')->paginate(10);

        return view('admin.user-management', compact('users'));
    }

    public function user_search(Request $request)
    {
        $search = $request->input('search');
        
        $users = User::where('name', 'LIKE', '%' . $search . '%')->orWhere('usertype', 'LIKE', '%' . $search . '%')->paginate(3);

        return view('admin.user-management', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }
    
    public function support()
    {
        // Buscar todos os problemas da base de dados
        $problems = Problem::all(); // Pode usar paginate() se quiser paginação
        return view('admin.support', compact('problems'));
    }

    public function maintenance(){
        
        return view('admin.maintenance');
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

        if ($user->usertype === 'owner') {
            toastr()->error('O Owner nao pode ser apagado');
            return redirect()->back();
        }
        $user->delete();

        toastr()->success('Utilizador apagado com sucesso');
        return redirect()->route('admin.user-management');
    }
}
