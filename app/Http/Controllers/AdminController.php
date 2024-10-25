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
}
