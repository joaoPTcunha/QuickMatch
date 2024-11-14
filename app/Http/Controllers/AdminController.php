<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\User;
use App\Models\Field;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user) {
            $usertype = $user->usertype;
            $name = $user->name;
    
            $userCount = User::whereIn('usertype', ['user', 'user_field'])->count();
            $fieldCount = Field::count();
    
            return view('admin.index', compact('usertype', 'name', 'userCount','fieldCount'));
        }
    
        return redirect()->route('login');
    }

    public function userManagement()
    {
        $users = User::select('id', 'name', 'email', 'usertype')->paginate(4);

        return view('admin.user-management', compact('users'));
    }

    public function user_search(Request $request)
    {
        $search = $request->input('search');
        $usertype = $request->input('usertype');
        
        $query = User::query();
    
        if ($usertype) {
            $query->where('usertype', $usertype);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')->orWhere('usertype', 'LIKE', '%' . $search . '%');
            });
        }
    
        $users = $query->paginate(5);
    
        return view('admin.user-management', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }   

    public function fieldsAdmin()
    {
        // Pega todos os campos cadastrados no banco de dados
        //$fields = Field::all(); // Se você quiser adicionar uma ordenação, por exemplo, por nome, use Field::orderBy('name')->get();

        // Retorna a view fields-admin com os campos
        return view('admin.fields-admin'); //compact('fields')
    }
    
    public function support()
    {
        $problems = Problem::where('is_solved', false)->get();
        return view('admin.support', compact('problems'));
    }

    public function problems_history()
    {
        $problems = Problem::where('is_solved', true)->get();
        return view('admin.problems_history', compact('problems'));
    }

    public function markAsSolved(Request $request, $id){
    $problem = Problem::findOrFail($id);
    $problem->is_solved = true;
    $problem->save();

    return response()->json(['status' => 'success', 'message' => 'Problem marked as solved']);
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
            toastr()->error('O Owner não pode ser apagado.');
            return redirect()->back();
        }
        $user->delete();

        toastr()->success('Utilizador apagado com sucesso!');
        return redirect()->route('admin.user-management');
    }
}
