<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public function guru()
    {
        return $this->belongsTo(User::class,'guru_id','id');
    }
    public function siswa()
    {
        return $this->belongsTo(User::class,'siswa_id','id');
    }
}
