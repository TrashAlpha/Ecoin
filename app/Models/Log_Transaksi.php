<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_Transaksi extends Model
{
    use HasFactory;

    protected $table = 'log__transaksis';

    protected $fillable = [
        'user_id',
        'jenis_transaksi',
        'tanggal_transaksi',
        'jumlah_koin',
        'reference_id',
        'reference_type'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'jumlah_koin' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_transaksi', $jenis);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Static methods
    public static function createLog($userId, $jenisTransaksi, $jumlahKoin, $reference = null)
    {
        return self::create([
            'user_id' => $userId,
            'jenis_transaksi' => $jenisTransaksi,
            'tanggal_transaksi' => now()->toDateString(),
            'jumlah_koin' => $jumlahKoin,
            'reference_id' => $reference ? $reference->id : null,
            'reference_type' => $reference ? get_class($reference) : null,
        ]);
    }
}
