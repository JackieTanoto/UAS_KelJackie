<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Progress;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Task;
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
        $token = Auth::user()->class_id;
        if ($request->ajax()) {
            $start = $request->start;
            DB::enableQueryLog();
            $collection = Schedule::select(DB::raw("schedules.id, schedules.course_id, schedules.class_id, schedules.start_at, schedules.end_at, schedules.url,
            rooms.title AS nama_kelas, rooms.year, courses.title AS nama_pelajaran, courses.description
            "))
            ->leftJoin('rooms', 'schedules.class_id', '=', 'rooms.id')
            ->leftJoin('courses', 'schedules.course_id', '=', 'courses.id')
            ->where('schedules.class_id',$token)
            ->where(DB::raw('date(schedules.start_at)'),'>=',$start)
            ->orderBy('schedules.id','ASC')
            // ->whereBetween(DB::raw('date(schedules.start_at)'), [$start, $end])
            ->paginate(10);
            return view('page.siswa.schedule.list', compact('collection'));
        }
        return view('page.siswa.schedule.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('siswa_id',$token)->get();
        $kelas = Room::get();
        return view('page.siswa.schedule.input', ['schedule' => new Schedule, 'course' => $course, 'kelas' => $kelas]);
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
        $course = Course::where('siswa_id',$token)->get();
        $kelas = Room::get();
        return view('page.siswa.schedule.input',compact('schedule','course','kelas'));
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
            $progress = Progress::where('task_id',$task->id)->first();
        }
        if($progress == null){
            $progress = new Progress;
        }else{
            $progress = $progress;
        }
        return view('page.siswa.schedule.task',compact('schedule','task','progress'));
    }

    public function attend(Request $request, Schedule $schedule)
    {
        $cek = Attendance::where('schedule_id',$schedule->id)
        ->where('siswa_id',Auth::user()->id)
        ->get();
        if($cek->count() < 1){
            $attendance = new Attendance;
            $attendance->schedule_id = $request->schedule->id;
            $attendance->siswa_id = Auth::user()->id;
            $attendance->st = 'h';
            $attendance->present_at = date("Y-m-d H:i:s");
            $attendance->save();
            return response()->json([
                'alert' => 'success',
                'message' => 'Absensi telah direkam',
            ]);
        }else{
            return response()->json([
                'alert' => 'info',
                'message' => 'Anda sudah absen',
            ]);
        }
    }
}
