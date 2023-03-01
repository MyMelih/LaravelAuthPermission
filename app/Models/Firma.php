<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    use HasFactory;

    protected $table = 'firma';

    protected $fillable = [
        's_no',
        'durum',
        'devre_no',
        'firma',
        'lokasyon',
        'devre_hizi',
        'koordinat',
        'bbk',
        'uc_vlan',
        'pop_vlan',
        'turu',
        'updated_at',
        'created_at'
    ];
}
