<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran_Koin extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe_penukaran',
        'nilai_koin',
        'nilai_rupiah',
        'tanggal_transaksi',
        'voucher_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucher()
    {
        return $this->hasOne(Voucher::class);
    }
}
