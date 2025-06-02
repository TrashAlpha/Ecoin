<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';

    protected $fillable = [
        'artikel_id',
        'pertanyaan',
        'pilihan_jawaban',
        'jawaban_benar',
        'urutan'
    ];

    protected $casts = [
        'pilihan_jawaban' => 'array',
        'urutan' => 'integer',
    ];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    public function scopeByArtikel($query, $artikelId)
    {
        return $query->where('artikel_id', $artikelId)->orderBy('urutan');
    }
}