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
        'nilai_koin' => 'integer',
    ];

    public function penukaranKoin()
    {
        return $this->belongsTo(PenukaranKoin::class);
    }

    // Relationships
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vouchers')
                    ->withPivot('tanggal_diperoleh', 'status')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
