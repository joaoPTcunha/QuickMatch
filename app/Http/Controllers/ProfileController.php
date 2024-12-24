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
        // Atualiza os campos do perfil
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->user_name = $request->input('user_name');
        $user->date_birth = $request->input('date_birth');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Verifica se o tipo de usuário foi alterado
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

        // Verifica se o usuário deseja remover a foto de perfil
        if ($request->input('remove_profile_picture')) {
            // Exclui a foto de perfil do diretório
            if ($user->profile_picture && file_exists(public_path('Profile_Photo/' . $user->profile_picture))) {
                unlink(public_path('Profile_Photo/' . $user->profile_picture));
            }
            // Remove o nome da foto de perfil do banco de dados
            $user->profile_picture = null;
        }

        // Se uma nova foto for enviada, armazenamos a imagem
        if ($request->hasFile('profile_picture')) {
            $this->storeUserProfileImage($request, $user);
        }

        // Salva as alterações
        $user->save();

        toastr()->timeout(10000)->closeButton()->success('Perfil atualizado com sucesso');
        return back()->with('status', 'profile-updated');
    }
}



protected function storeUserProfileImage(Request $request, User $user)
{
    if ($request->hasFile('profile_picture')) {
        // Remove a foto antiga se houver
        if ($user->profile_picture && file_exists(public_path('Profile_Photo/' . $user->profile_picture))) {
            unlink(public_path('Profile_Photo/' . $user->profile_picture));
        }

        // Armazena a nova foto
        $image = $request->file('profile_picture');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('Profile_Photo'), $imageName);

        // Atualiza o banco de dados com o nome da nova foto
        $user->profile_picture = $imageName;
    }
}



    /**
     * Delete the user's account.
     */
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
