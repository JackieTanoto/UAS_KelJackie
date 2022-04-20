<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Room;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Room::select(DB::raw('rooms.id'),DB::raw('rooms.title as kelas'), DB::raw('courses.title as pelajaran'), DB::raw('COUNT(schedules.id) as total_jadwal'))
            ->join('schedules','schedules.class_id','=','rooms.id')
            ->join('courses','courses.id','=','schedules.course_id')  
            ->join('users','courses.guru_id','=','users.id')
            ->where('rooms.title','like','%'.$keywords.'%')
            ->orWhere('courses.title','like','%'.$keywords.'%')
            ->where('courses.guru_id', Auth::user()->id)
            // ->groupBy('attendances.siswa_id')
            ->groupBy('rooms.id')
            ->groupBy('courses.title')
            ->paginate(10);
            return view('page.guru.room.list', compact('collection'));
        }
        return view('page.guru.room.main');
    }
    public function create()
    {

    }
    public function store()
    {
        
    }
    public function show(Room $room, Request $request)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Schedule::select(DB::raw('COUNT(attendances.id) as total_absen'), DB::raw('users.name as nama_siswa'))
            ->join('courses','courses.id','=','schedules.course_id')  
            ->join('attendances','attendances.schedule_id','=','schedules.id')
            ->join('users','attendances.siswa_id','=','users.id')
            ->where('users.name','like','%'.$keywords.'%')
            ->where('courses.guru_id', Auth::user()->id)
            ->where('schedules.class_id', $room->id)
            ->groupBy('attendances.siswa_id')
            ->paginate(10);
            return view('page.guru.room.list_siswa', compact('collection'));
        }
        return view('page.guru.room.show',compact('room'));
    }
    public function edit()
    {
        //
    }
    public function update()
    {
        //
    }
    public function destroy()
    {
      
    }
}
