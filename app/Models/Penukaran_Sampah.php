<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penukaran_Sampah extends Model
{
    use HasFactory;

    protected $table = 'penukaran__sampahs';

    protected $fillable = [
        'user_id',
        'detail_sampah',
        'tanggal_penukaran',
        'waktu_penukaran',
        'lokasi_penukaran',
        'alamat_detail',
        'latitude',
        'longitude',
        'bukti_transaksi',
        'total_koin',
        'status',
        'catatan_admin'
    ];

    protected $casts = [
        'detail_sampah' => 'array',
        'bukti_transaksi' => 'array',
        'total_koin' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'tanggal_penukaran' => 'date',
        'waktu_penukaran' => 'datetime:H:i',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logTransaksi()
    {
        return $this->morphMany(Log_Transaksi::class, 'reference');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Methods
    public function approve($adminNote = null)
    {
        $this->update([
            'status' => 'approved',
            'catatan_admin' => $adminNote
        ]);
        
        // Add coins to user
        $this->user->addKoin($this->total_koin);
    }

    public function reject($adminNote = null)
    {
        $this->update([
            'status' => 'rejected',
            'catatan_admin' => $adminNote
        ]);
    }
}
