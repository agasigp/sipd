<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function aspek()
    {
        return $this->hasMany(Aspek::class, 'roles_id');
    }
}
