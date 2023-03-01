<?php

namespace App\Exports;


use App\Models\Firma;
use Maatwebsite\Excel\Concerns\FromCollection;

class FirmaExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Firma::all();
    }
}
