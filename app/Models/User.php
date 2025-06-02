<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'saldo_koin',
        'akun_facebook',
        'akun_twitter',
        'role',
        'status',
        'photo_profile_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'saldo_koin' => 'integer',
        ];
    }

    // Relationships
    public function penukaranSampah()
    {
        return $this->hasMany(Penukaran_Sampah::class);
    }

    public function penukaranKoin()
    {
        return $this->hasMany(Penukaran_Koin::class);
    }

    public function logTransaksi()
    {
        return $this->hasMany(Log_Transaksi::class);
    }

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }

    // Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function addKoin($amount)
    {
        $this->increment('saldo_koin', $amount);
    }

    public function subtractKoin($amount)
    {
        if ($this->saldo_koin >= $amount) {
            $this->decrement('saldo_koin', $amount);
            return true;
        }
        return false;
    }
}
