<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class RolesEkleController extends Controller
{
    public function index()
    {
        if (Gate::denies('roles-ekle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }
        return view('roles.ekle');
    }

    public function ekle(Request $request)
    {
        if (Gate::denies('roles-ekle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $data = [
                'name' => $request->name,
            ];

            Roles::create($data);
            return redirect('/roles/ekle')->with('success', 'Rol başarıyla eklendi.');
        }
    }
}
