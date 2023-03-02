<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;


class UserController extends Controller
{
    public function index()
    {
        if (Gate::denies('user-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $users = User::all();
            $roles = Roles::all();
            return view('user.index', compact('users', 'roles'));
        }
    }

    public function userListele(Request  $request)
    {
        if (Gate::denies('user-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            if ($request->ajax()) {
                $data = User::query();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return '<div class="btn-group">
                                    <button class="btn btn-sm btn-primary" name="editUserBtn" data-id="' . $row['id'] . '" id="editUserBtn">Düzenle</button>
                                    <button class="btn btn-sm btn-danger" name="deleteUserBtn" data-id="' . $row['id'] . '" id="deleteUserBtn">Sil</button>
                                </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('user.listele', compact('data'));
        }
    }

    function userDetay($id)
    {
        if (Gate::denies('user-detay')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $data = User::findOrFail($id);
            return response()->json($data);
        }
    }

    function userGuncelle(Request $request, $id)
    {
        if (Gate::denies('user-guncelle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $user = User::find($id);
            if ($user) {
                $user->update($request->all());
                return redirect()->json(['success' => 'Kullanıcı başarıyla güncellendi.']);
            } else {
                return redirect()->json(['error' => 'Kullanıcı bulunamadı.']);
            }
        }
    }

    public function userSil($id)
    {
        if (Gate::denies('user-sil')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $user = User::find($id);
            if ($user) {
                $user->delete();
                if ($request->ajax()) {
                    return response()->json(['success' => true], 200);
                } else {
                    return redirect()->back()->with('success', 'Kullanıcı başarıyla silindi.');
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['success' => false], 404);
                } else {
                    return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
                }
            }
        }
    }


    public function rolSil($id)
    {
        if (Gate::denies('user-rolSil')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $user = User::find($id);
            DB::table('role_user')->where('user_id', $user->id)->delete();
            return redirect()->back()->with('success', 'Kullanıcının rolleri başarıyla silindi.');
        }
    }

    public function saveUserRoles(Request $request)
    {
        if (Gate::denies('save-roles')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $userId = $request->input('user_id');
            $roleIds = $request->input('role_ids');
            $name = $request->input('name');
            $isAdmin = $request->input('isAdmin');
            $email = $request->input('email');


            $existingUser = DB::table('users')->where('email', $email)->first();

            if ($existingUser) {
                DB::table('users')
                    ->where('email', $email)
                    ->update([
                        'name' => $name,
                        'isAdmin' => $isAdmin
                    ]);

                $userId = $existingUser->id;
            } else {
                DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'isAdmin' => $isAdmin
                ]);

                $userId = DB::getPdo()->lastInsertId();
            }

            $existingRoles = DB::table('role_user')
                ->where('user_id', $userId)
                ->pluck('role_id')
                ->toArray();

            foreach ($roleIds as $roleId) {
                if (!in_array($roleId, $existingRoles)) {
                    DB::table('role_user')->insert([
                        'user_id' => $userId,
                        'role_id' => $roleId,
                    ]);
                }
            }

            foreach ($existingRoles as $existingRoleId) {
                if (!in_array($existingRoleId, $roleIds)) {
                    DB::table('role_user')
                        ->where('user_id', $userId)
                        ->where('role_id', $existingRoleId)
                        ->delete();
                }
            }

            return response()->json(['success' => true]);
        }
    }

    public function userRoles($id)
    {

        if (Gate::denies('get-user-roles')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $roles = DB::table('role_user')
                ->where('user_id', $id)
                ->get()
                ->pluck('role_id')
                ->toArray();
            return response()->json($roles);
        }
    }
}
