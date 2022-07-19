<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHoliday extends Model
{
    public $timestamps = true;

    protected $table = 'student_holidays';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $guarded = ['id'];


}
