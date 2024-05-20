<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = "users";

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
    public function sub_region()
    {
        return $this->belongsTo(SubRegion::class);
    }
    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'desa_id');
    }
}
