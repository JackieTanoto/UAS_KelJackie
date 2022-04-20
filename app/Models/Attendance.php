<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $dates = ['present_at'];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class,'schedule_id','id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class,'siswa_id','id');
    }
}
