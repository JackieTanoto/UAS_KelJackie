<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $dates = ['start_at','end_at'];
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'class_id','id');
    }
    public function task()
    {
        return $this->hasOne(Task::class,'schedule_id','id');
    }
}
