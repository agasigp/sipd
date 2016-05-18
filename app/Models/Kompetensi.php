<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $table = 'kompetensi';

    public function aspeks()
    {
        return $this->hasMany(Aspek::class, 'kompetensi_id');
    }
}
