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
            $data = [
                's_no' => $request->s_no,
                'durum' => $request->durum,
                'devre_no' => $request->devre_no,
                'firma' => $request->firma,
                'lokasyon' => $request->lokasyon,
                'devre_hizi' => $request->devre_hizi,
                'koordinat' => $request->koordinat,
                'bbk' => $request->bbk,
                'uc_vlan' => $request->uc_vlan,
                'pop_vlan' => $request->pop_vlan,
                'turu' => $request->turu,
            ];

            Firma::create($data);
            return redirect('/firma/list')->with('success', 'Firma başarıyla eklendi.');
        }
    }
}