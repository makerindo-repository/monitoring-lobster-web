<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pakan()
    {
        return $this->hasMany(LogPakan::class);
    }
}
