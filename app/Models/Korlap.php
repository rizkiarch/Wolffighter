<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Korlap extends Model
{
    use HasFactory;

    protected $appends = ['show_details'];

    protected $guarded = [];

    public function getShowDetailsAttribute()
    {
        return false;
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(KorlapDetail::class);
    }
}
