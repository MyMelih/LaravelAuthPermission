<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;


class RolesListController extends Controller
{
    public function index()
    {
        if (Gate::denies('roles-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }
        return view('roles.list');
    }

    public function ekle(Request $request)
    {
        if (Gate::denies('roles-ekle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $role = new Roles();
            $role->name = $request->input('name');
            $role->save();

            return view('roles.list')->with('success', 'Rol başarıyla eklendi.');
        }
    }


    public function rolesListele(Request $request)
    {
        if (Gate::denies('roles-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            if ($request->ajax()) {
                $data = Roles::latest();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        if (Gate::check('roles-sil')) {
                            $deleteButton = '<button class="btn btn-sm btn-danger" name="deleteRolesBtn" data-id="' . $row['id'] . '" id="deleteRolesBtn">Sil</button>';
                        } else {
                            $deleteButton = '';
                        }

                        if (Gate::check('roles-guncelle')) {
                            $editButton = '<button class="btn btn-sm btn-primary" name="editRolesBtn" data-id="' . $row['id'] . '" id="editRolesBtn">Düzenle</button>';
                        } else {
                            $editButton = '';
                        }

                        return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return Datatables::of($data);
        }
    }

    function rolesDetay($id)
    {
        if (Gate::denies('roles-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $data = Roles::findOrFail($id);
            return response()->json($data);
        }
    }

    function rolesGuncelle(Request $request, $id)
    {
        if (Gate::denies('roles-guncelle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $roles = Roles::find($id);
            if ($roles) {
                $roles->name = $request->name;
                $roles->save();
                return response()->json(['success' => 'Kayıt başarıyla güncellendi.']);
            } else {
                return response()->json(['error' => 'Kayıt bulunamadı.']);
            }
        }
    }

    function rolesSil($id)
    {
        if (Gate::denies('roles-sil')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $roles = Roles::find($id);
            if ($roles) {
                $roles->delete();
                return response()->json(['success' => 'Kayıt başarıyla silindi.']);
            } else {
                return response()->json(['error' => 'Kayıt bulunamadı.']);
            }
        }
    }
}
