<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleV2 extends Model
{
    public $timestamps = true;

    protected $table = 'roles';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];


    public function role_users()
    {
        return $this->hasMany(RoleUser::class, 'role_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }
}
