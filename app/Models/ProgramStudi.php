<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramStudi extends Model
{
    use SoftDeletes;

    protected $table = 'program_studi';
    protected $dates = ['deleted_at'];
    protected $fillable = ['nama', 'deskripsi'];

    public function users()
    {
        return $this->hasMany(User::class, 'program_studi_id');
    }
}
