<?php

namespace App\Imports;

use App\Models\Firma;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class FirmaImport implements ToModel, WithStartRow
{

    public function model(array $row)
    {
        return new Firma([
            's_no' => $row[0],
            'durum' => $row[1],
            'devre_no' => $row[2],
            'firma' => $row[3],
            'lokasyon' => $row[4],
            'devre_hizi' => $row[5],
            'koordinat' => $row[6],
            'bbk' => $row[7],
            'uc_vlan' => $row[8],
            'pop_vlan' => $row[9],
            'turu' => $row[10],
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
}
