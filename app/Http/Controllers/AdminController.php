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

            return view('admin.index', compact('usertype', 'name', 'userCount', 'fieldCount'));
        }

        return redirect()->route('login');
    }

    public function userManagement()
    {
        $users = User::select([
            'id',
            'name',
            'email',
            'usertype',
            'surname',
            'user_name',
            'date_birth',
            'gender',
            'phone',
            'address',
            'profile_picture'
        ])->get();

        $users = User::paginate(6);

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
            $query->where(function ($q) use ($search) {
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
        $fields = Field::all();
        return view('admin.fields-admin', compact('fields'));
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

    public function markAsSolved($id)
    {
        $problem = Problem::findOrFail($id);
        $problem->is_solved = true;
        $problem->save();

        return response()->json(['status' => 'success', 'message' => 'Problem marked as solved']);
    }


    public function maintenance()
    {
        return view('admin.maintenance');
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'date_birth' => 'nullable|date',
            'gender' => 'nullable|in:Masculino,Feminino,Outro',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'usertype' => 'required|in:admin,user,user_field',
        ]);

        $user->name = $validatedData['name'];
        $user->surname = $validatedData['surname'];
        $user->user_name = $validatedData['user_name'];
        $user->date_birth = $validatedData['date_birth'];
        $user->gender = $validatedData['gender'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->address = $validatedData['address'];

        $user->save();

        toastr()->timeout(10000)->closeButton()->success('Perfil de ' . $user->name . ' atualizado com sucesso!');
        return redirect()->route('admin.user-management');
    }

    public function ProfilePictureDelete(User $user)
    {
        if ($user->profile_picture) {
            $imagePath = public_path('Profile_Photo/' . $user->profile_picture);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $user->profile_picture = null;
            $user->save();
            toastr()->timeout(10000)->closeButton()->success('Image de perfil do "' . $user->name . '" foi removida com sucesso!');
        }
        return redirect()->route('admin.user-management');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $loginUser = Auth::user();

        if ($loginUser->usertype === 'admin') {
            if ($user->usertype === 'admin') {
                toastr()->timeout(10000)->closeButton()->error('Admin não pode apagar outro Admin');
                return redirect()->back();
            }

            if ($user->usertype === 'owner') {
                toastr()->timeout(10000)->closeButton()->error('Admin não pode apagar o Owner');
                return redirect()->back();
            }

            if ($loginUser->id === $user->id) {
                toastr()->timeout(10000)->closeButton()->error('Você não pode apagar sua própria conta.');
                return redirect()->back();
            }
        }

        if ($loginUser->usertype === 'owner' && $loginUser->id === $user->id) {
            toastr()->timeout(10000)->closeButton()->error('O Owner não pode apagar a sua própria conta.');
            return redirect()->back();
        }
        $user->delete();
        toastr()->timeout(10000)->closeButton()->success($user->name . ' (' . $user->usertype . ') apagado com sucesso!');

        return redirect()->route('admin.user-management');
    }
}
