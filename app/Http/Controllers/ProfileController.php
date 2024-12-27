<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;

//EDITAR PERFIL
class ProfileController extends Controller
{

    public function edit(Request $request): View
    {
        $usertype = Auth::user()->usertype;
        return view('profile.edit', [
            'user' => $request->user(),
            'usertype' => $usertype,
        ]);
    }


    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'nullable|string|max:255',
        'user_name' => 'nullable|string|max:255',
        'date_birth' => 'nullable|date',
        'gender' => 'nullable|string|in:Male,Female,Other',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'usertype' => 'nullable|string|in:user,user_field',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
        'remove_profile_picture' => 'nullable|boolean',
    ]);

    $user = Auth::user();

    if ($user instanceof User) {
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->user_name = $request->input('user_name');
        $user->date_birth = $request->input('date_birth');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        if ($request->has('usertype')) {
            $newUsertype = $request->input('usertype');

            if ($user->usertype === 'user_field' && $newUsertype === 'user') {
                if ($user->fields()->exists()) {
                    toastr()->timeout(10000)->closeButton()->error('Por favor, apague os campos associados antes de mudar de tipo de utilizador.');
                    return back()->withInput();
                }
            }

            if (in_array($user->usertype, ['user', 'user_field'])) {
                $user->usertype = $newUsertype;
            }
        }

        if ($request->input('remove_profile_picture')) {
            if ($user->profile_picture && file_exists(public_path('Profile_Photo/' . $user->profile_picture))) {
                unlink(public_path('Profile_Photo/' . $user->profile_picture));
            }
            $user->profile_picture = null;
        }

        if ($request->hasFile('profile_picture')) {
            $this->storeUserProfileImage($request, $user);
        }

        $user->save();

        toastr()->timeout(10000)->closeButton()->success('Perfil atualizado com sucesso');
        return back()->with('status', 'profile-updated');
    }
}


//ATUALIZAR IMAGEM DE PERFIL
protected function storeUserProfileImage(Request $request, User $user)
{
    if ($request->hasFile('profile_picture')) {
        if ($user->profile_picture && file_exists(public_path('Profile_Photo/' . $user->profile_picture))) {
            unlink(public_path('Profile_Photo/' . $user->profile_picture));
        }

        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Profile_Photo'), $imageName);

        $user->profile_picture = $imageName;
    }
}

//APAGAR CONTA
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
