<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'judul',
        'konten',
        'gambar_url',
        'kategori',
        'views',
        'reward_koin',
        'status'
    ];

    protected $casts = [
        'views' => 'integer',
        'reward_koin' => 'integer',
    ];

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
} 