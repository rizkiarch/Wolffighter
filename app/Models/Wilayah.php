<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Wilayah extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "_wilayah_nkri";

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    protected $appends = [
        'detail',
    ];

    public function getDetailAttribute()
    {
        // 92.71.10
        return self::where('code', $this->parent)->first();
    }
}
