<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Camera;

class Kja extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'kja';

    public function cameras()
    {
        return $this->hasMany(Camera::class);
    }
}
