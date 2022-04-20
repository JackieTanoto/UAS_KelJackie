<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $dates = ['due_at'];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class,'schedule_id','id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class,'siswa_id','id');
    }
    public function progress()
    {
        return $this->belongsTo(Progress::class,'task_id','id');
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
