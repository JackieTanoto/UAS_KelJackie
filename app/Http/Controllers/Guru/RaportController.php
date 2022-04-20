<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\Progress;
use App\Models\Room;
use App\Models\User;
use App\Models\Raport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RaportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $keywords = $request->keywords;
            $collection = Raport::paginate(10);
            return view('page.guru.raport.list', compact('collection'));
        }
        return view('page.guru.raport.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        return view('page.guru.raport.input', ['raport' => new Raport, 'course' => $course]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courses_id' => 'required',
            'kelas_id' => 'required',
            'siswa_id' => 'required',
            'kehadiran' => 'required',
            'tugas' => 'required',
            'uts' => 'required',
            'uas' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('courses_id')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('courses_id'),
                ]);
            }elseif ($errors->has('kelas_id')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kelas_id'),
                ]);
            }elseif ($errors->has('siswa_id')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('siswa_id'),
                ]);
            }elseif($errors->has('kehadiran')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kehadiran'),
                ]);
            }elseif($errors->has('uts')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('uts'),
                ]);
            }elseif($errors->has('uas')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('uas'),
                ]);
            }
            else{
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tugas'),
                ]);
            }
        }
        $task = new Raport;
        $task->courses_id = $request->courses_id ;
        $task->kelas_id = $request->kelas_id ;
        $task->siswa_id = $request->siswa_id ;
        $task->kehadiran = $request->kehadiran; 
        $task->tugas = $request->tugas ;
        $task->uts = $request->uts; 
        $task->uas = $request->uas; 
        $task->created_at = date('Y-m-d H:i:s'); 
        $task->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Data Raport '. $request->title . ' tersimpan',
        ]);
    }
    public function edit(Raport $raport)
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        $room = Room::get();
        $user = User::where('role','s')->get();
        return view('page.guru.raport.input',compact('raport','course','room','user'));
    }
    public function update(Request $request, Raport $raport)
    {
        $validator = Validator::make($request->all(), [
            'kehadiran' => 'required',
            'tugas' => 'required',
            'uts' => 'required',
            'uas' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('kehadiran')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('kehadiran'),
                ]);
            }elseif ($errors->has('tugas')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('tugas'),
                ]);
            }elseif ($errors->has('uts')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('uts'),
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('uas'),
                ]);
            }
        }

        $raport->kehadiran = $request->kehadiran; 
        $raport->tugas = $request->tugas ;
        $raport->uts = $request->uts; 
        $raport->uas = $request->uas; 
        $raport->created_at = date('Y-m-d H:i:s'); 
        $raport->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Data Raport '. $request->title . ' terupdate',
        ]);
    }
    public function destroy(Raport $raport)
    {
        $raport->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Data Raport '. $raport->title . ' terhapus',
        ]);
    }
    public function generatePDF()
    {
        $raport = Raport::get();
        $data = ['title' => 'Raport', 'raport'=>$raport];
        $pdf = PDF::loadView('page.guru.raport.pdf', $data);
        return $pdf->download('raport.pdf');
    }
    public function list_kelas(Request $request)
    {
        $result = Schedule::select('rooms.id', 'rooms.title')
        ->join('rooms', 'rooms.id','=','schedules.class_id')
        ->where(DB::raw('course_id'), $request->pelajaran)
        ->groupBy('rooms.id')
        ->get();
        $list = "<option value=''>Pilih Kelas</option>";
        foreach ($result as $row) {
            $list.= "<option value='$row[id]'>$row[title]</option>";
        }
        echo $list;
    }
    public function list_siswa(Request $request)
    {
        $result = User::where(DB::raw('class_id'), $request->kelas)
        ->get();
        $list = "<option value=''>Pilih Kelas</option>";
        foreach ($result as $row) {
            $list.= "<option value='$row[id]'>$row[name]</option>";
        }
        echo $list;
    }
    public function getKehadiran(Request $request)
    {
        $total_jadwal = Schedule::where(DB::raw('course_id'),$request->pelajaran)->where(DB::raw('class_id'), $request->kelas)->get();
        $total_absen = Attendance::select(DB::raw("COUNT(attendances.id) as total"))
        ->join('schedules','schedules.id','=','attendances.schedule_id')
        ->where(DB::raw('attendances.siswa_id'), $request->siswa)
        ->where(DB::raw('schedules.course_id'), $request->pelajaran)
        ->where(DB::raw('schedules.class_id'), $request->kelas)
        ->first();

        $akumulasi = ($total_absen->total/$total_jadwal->count())*100;
        return number_format($akumulasi);
    }
}
