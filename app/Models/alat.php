<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'nama_alat',
        'tahun',
        'merek',
        'lokasi',
    ];
}
