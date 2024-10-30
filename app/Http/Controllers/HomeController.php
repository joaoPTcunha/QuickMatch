<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
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

    public function aaa(){
        return view('home.seematch');
    }

    public function spinwheel(){
        return view('home.spinwheel');
    }

    public function field(){
        return view('home.field');
    }

    public function contact(){
        return view('home.contact');
    }

    public function newmatch(){
        return view('home.newmatch');
    }

    public function seematch(){
        return view('home.seematch');
    }

    public function help(){
        return view('home.help');
    }



}
