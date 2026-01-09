<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::withCount('practicos')->get();
        return view('admin.users.index', compact('users'));
    }

    public function userDetail($id)
    {
        $user = User::with(['practicos' => function ($q) {
            $q->withCount('ejercicios');
        }])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
