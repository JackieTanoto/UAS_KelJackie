<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    use HasFactory;
    protected $table = 'tasks_detail';
    protected $dates = ['due_at'];
    public $timestamps = false;
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id','id');
    }
}
