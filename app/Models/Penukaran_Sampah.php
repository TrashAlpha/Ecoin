<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran_Sampah extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_sampah',
        'berat_sampah',
        'tanggal_penukaran',
        'waktu_penukaran',
        'bukti_transaksi',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
