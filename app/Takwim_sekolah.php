<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Takwim_sekolah extends Model
{
    public $timestamps = true;

    protected $table = 'takwim_sekolah';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];

    
}
