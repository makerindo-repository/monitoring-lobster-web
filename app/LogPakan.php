<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogPakan extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }
}
