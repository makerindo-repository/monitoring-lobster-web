<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kja;

class Camera extends Model 
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function kja()
    {
        return $this->belongsTo(Kja::class, 'kja_id');
    }
}
