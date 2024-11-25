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
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
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

            if ($request->hasFile('profile_picture')) {
                $this->storeUserProfileImage($request, $user);
            }

            $user->save();

            toastr()->timeout(10000)->closeButton()->success('Perfil atualizado com sucesso');

            return back()->with('status', 'profile-updated');
        }
    }

    private function storeUserProfileImage($request, $user)
    {
        if ($user->profile_picture && file_exists(public_path('Profile_Photo/' . $user->profile_picture))) {
            unlink(public_path('Profile_Photo/' . $user->profile_picture));
        }

        $imageName = time() . '.' . $request->file('profile_picture')->extension();
        $request->file('profile_picture')->move(public_path('Profile_Photo'), $imageName);

        $user->profile_picture = $imageName;
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
