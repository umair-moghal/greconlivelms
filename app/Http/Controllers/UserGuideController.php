<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserGuideController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view ('user_guide.index', compact('user'));
    }
}
