<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nama_voucher',
        'nilai_koin',
        'deskripsi',
        'image_url',
        'status'
    ];

    protected $casts = [
        'nilai_koin' => 'float',
    ];

    public function penukaranKoin()
    {
        return $this->belongsTo(PenukaranKoin::class);
    }
}
