<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function index()
    {
        if (Gate::denies('user-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $users = User::all();
            return view('admin.users', ['users' => $users]);
        }
    }
}
