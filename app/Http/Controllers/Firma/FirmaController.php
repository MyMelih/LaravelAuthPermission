<?php

namespace App\Http\Controllers\Firma;

use Excel;

use Illuminate\Http\Request;
use App\Imports\FirmaImport;
use App\Exports\FirmaExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;


class FirmaController extends Controller
{
    public function indir()
    {
        if (Gate::denies('excel-indir')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }
        return Excel::download(new FirmaExport, 'firmalar.xlsx');
    }

    public function excelYukle(Request $request)
    {
        if (Gate::denies('excel-yukle')) {
            return redirect()->back()->with('error', 'Bu işlem için yetkiniz yok.');
        }

        Excel::import(new FirmaImport, $request->file('file'));
        return redirect()->back()->with('success', 'Kayıtlar başarıyla yüklendi.');
    }
}
