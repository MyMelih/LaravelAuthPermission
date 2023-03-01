<?php

namespace App\Http\Controllers\Firma;

use App\Models\Firma;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;


class ListController extends Controller
{
    public function index()
    {
        if (Gate::denies('firma-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }
        return view('list');
    }

    public function firmaListele(Request $request)
    {
        if (Gate::denies('firma-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            if ($request->ajax()) {
                $data = Firma::latest();
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        if (Gate::check('firma-sil')) {
                            $deleteButton = '<button class="btn btn-sm btn-danger" name="deleteCountryBtn" data-id="' . $row['id'] . '" id="deleteCountryBtn">Sil</button>';
                        } else {
                            $deleteButton = '';
                        }
                        if (Gate::check('firma-guncelle')) {
                            $editButton = '<button class="btn btn-sm btn-primary" name="editCountryBtn" data-id="' . $row['id'] . '" id="editCountryBtn">Düzenle</button>';
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

    function firmaDetay($id)
    {
        if (Gate::denies('firma-listele')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $data = Firma::findOrFail($id);
            return response()->json($data);
        }
    }

    function firmaGuncelle(Request $request, $id)
    {
        if (Gate::denies('firma-guncelle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $firma = Firma::find($id);
            if ($firma) {
                $firma->update($request->all());
                return response()->json(['success' => 'Firma başarıyla güncellendi.']);
            } else {
                return response()->json(['error' => 'Firma bulunamadı.']);
            }
        }
    }

    public function firmaSil($id)
    {
        if (Gate::denies('firma-sil')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $firma = Firma::find($id);
            if ($firma) {
                $firma->delete();
                return response()->json(['success' => 'Firma başarıyla silindi.']);
            } else {
                return response()->json(['error' => 'Firma bulunamadı.']);
            }
        }
    }
}
