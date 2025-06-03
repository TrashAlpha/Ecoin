<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampah extends Model
{
    use HasFactory;

    protected $table = 'sampah';

    protected $fillable = [
        'nama_sampah',
        'tipe_sampah',
        'nilai_koin_per_kg',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'nilai_koin_per_kg' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe_sampah', $tipe);
    }
} 