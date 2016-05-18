<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';

    public function users()
    {
        return $this->hasMany(User::class, 'program_studi_id');
    }
}
