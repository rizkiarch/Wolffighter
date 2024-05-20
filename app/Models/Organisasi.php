<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'provinsi' => 'string',
        'kabupaten' => 'string',
        'kecamatan' => 'string',
        'desa' => 'string',
    ];

    public function sub_region()
    {
        return $this->belongsTo(SubRegion::class);
    }
    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
