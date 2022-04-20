<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $token = Auth::user()->id;
        if ($request->ajax()) {
            $start = $request->start;
            $end = $request->end;
            $collection = Schedule::select(DB::raw("schedules.id, schedules.course_id, schedules.class_id, schedules.start_at, schedules.end_at, schedules.url,
            rooms.title AS nama_kelas, rooms.year, courses.title AS nama_pelajaran, courses.description
            "))
            ->leftJoin('rooms', 'schedules.class_id', '=', 'rooms.id')
            ->leftJoin('courses', 'schedules.course_id', '=', 'courses.id')
            ->leftJoin('users', 'courses.guru_id', '=', 'users.id')
            ->where('courses.guru_id',$token)
            ->whereBetween(DB::raw('date(schedules.start_at)'), [$start, $end])
            ->paginate(10);

            // Your Eloquent query executed by using get()
            return view('page.guru.schedule.list', compact('collection'));
        }
        return view('page.guru.schedule.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        $kelas = Room::get();
        return view('page.guru.schedule.input', ['schedule' => new Schedule, 'course' => $course, 'kelas' => $kelas]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelajaran' => 'required',
            'kelas' => 'required',
            'url' => 'required',
            'tanggal' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('pelajaran')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('pelajaran'),
                ]);
            }elseif ($errors->has('kelas')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kelas'),
                ]);
            }elseif ($errors->has('url')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('url'),
                ]);
            }elseif ($errors->has('tanggal')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tanggal'),
                ]);
            }elseif ($errors->has('mulai')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('mulai'),
                ]);
            }elseif ($errors->has('selesai')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('selesai'),
                ]);
            }
        }
        $tanggal = $request->tanggal;
        $start = $tanggal. ' ' . $request->mulai;
        $end = $tanggal. ' ' . $request->selesai;
        
        $cek = Schedule::where("course_id",$request->pelajaran)
        ->where('class_id',$request->kelas)
        ->where('end_at','>',$start)
        ->where('start_at','<',$end)
        ->get()->count();
        
        if($cek > 0){
            return response()->json([
                'alert' => 'info',
                'message' => 'Pelajaran ini pada Tanggal ' .$request->tanggal. ' jam ' .$request->mulai . ' sampai jam '.$request->selesai.' sudah terjadwal',
            ]);
        }
        $schedule = new Schedule;
        $schedule->course_id = $request->pelajaran;
        $schedule->class_id = $request->kelas;
        $schedule->start_at = $start;
        $schedule->end_at = $end;
        $schedule->url = $request->url;
        $schedule->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Jadwal tersimpan',
        ]);
    }
    public function show(Schedule $schedule)
    {
        //
    }
    public function edit(Schedule $schedule)
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        $kelas = Room::get();
        return view('page.guru.schedule.input',compact('schedule','course','kelas'));
    }
    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'pelajaran' => 'required',
            'kelas' => 'required',
            'url' => 'required',
            'tanggal' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('pelajaran')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('pelajaran'),
                ]);
            }elseif ($errors->has('kelas')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kelas'),
                ]);
            }elseif ($errors->has('url')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('url'),
                ]);
            }elseif ($errors->has('tanggal')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tanggal'),
                ]);
            }elseif ($errors->has('mulai')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('mulai'),
                ]);
            }elseif ($errors->has('selesai')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('selesai'),
                ]);
            }
        }
        $tanggal = $request->tanggal;
        $start = $tanggal. ' ' . $request->mulai;
        $end = $tanggal. ' ' . $request->selesai;
        $cek = Schedule::where("course_id",$request->pelajaran)
        ->where('class_id',$request->kelas)
        ->where('end_at','>',$start)
        ->where('start_at','<',$end)
        ->get()->count();
        
        if($cek > 0){
            return response()->json([
                'alert' => 'info',
                'message' => 'Pelajaran ini pada Tanggal ' .$request->tanggal. ' jam ' .$request->mulai . ' sampai jam '.$request->selesai.' sudah terjadwal',
            ]);
        }
        
        $schedule->course_id = $request->pelajaran;
        $schedule->class_id = $request->kelas;
        $schedule->start_at = $start;
        $schedule->end_at = $end;
        $schedule->url = $request->url;
        $schedule->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Jadwal terupdate',
        ]);
    }
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Jadwal terhapus',
        ]);
    }
    public function task(Schedule $schedule)
    {
        $task = Task::where('schedule_id',$schedule->id)->first();
        if($task == null){
            $task = new Task;
        }else{
            $task = $task;
        }
        return view('page.guru.schedule.task',compact('schedule','task'));
    }
    public function progress(Request $request, Task $task)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Progress::where('file','like','%'.$keywords.'%')
            ->paginate(10);
            return view('page.guru.task.list', compact('collection'));
        }
        return view('page.guru.task.progress', compact('task'));
    }
}
