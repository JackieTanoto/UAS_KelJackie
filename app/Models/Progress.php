<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id','id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class,'siswa_id','id');
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class,'schedule_id','id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class,'class_id','id');
    }
}