<?php

namespace App\Http\Controllers\Firma;

use Illuminate\Http\Request;
use App\Models\Firma;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class EkleController extends Controller
{
    public function index()
    {
        if (Gate::denies('firma-ekle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }
        return view('ekle');
    }

    public function ekle(Request $request)
    {
        if (Gate::denies('firma-ekle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        } else {
            $data = $request->only([
                's_no', 'durum', 'devre_no', 'firma', 'lokasyon', 'devre_hizi', 'koordinat', 'bbk', 'uc_vlan', 'pop_vlan', 'turu'
            ]);
            $firma = new Firma($data);
            $firma->save();

            return view('ekle')->with('success', 'Firma başarıyla eklendi.');
        }
    }
}
