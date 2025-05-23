<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_Transaksi extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_transaksi',
        'tanggal_transaksi',
        'jumlah_koin',
        'reference_id',
        'reference_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }
}
