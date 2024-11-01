<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user) {
            $usertype = $user->usertype;
            $name = $user->name;
            return view('admin.index', compact('usertype', 'name'));
        }
    
        return redirect()->route('login');
    }

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
        $problems = Problem::all(); 
        return view('admin.support', compact('problems'));
    }

    public function maintenance(){
        
        return view('admin.maintenance');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

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
