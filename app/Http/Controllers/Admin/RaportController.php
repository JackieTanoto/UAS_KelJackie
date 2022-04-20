<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Task;
use PDF;
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
            return view('page.admin.raport.list', compact('collection'));
        }
        return view('page.admin.raport.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('admin_id',$token)->get();
        $room = Room::get();
        $user = User::where('role','s')->get();
        return view('page.admin.raport.input', ['task' => new Task, 'course' => $course, 'room'=> $room,'user'=>$user]);
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
            'message' => 'Tugas '. $request->title . ' tersimpan',
        ]);
    }
    public function edit()
    {
        $token = Auth::user()->id;
        $course = Course::where('admin_id',$token)->get();
        $raport = Raport::get();
        $room = Room::get();
        $user = User::where('role','s')->get();
        return view('page.admin.raport.list_detail', ['task' => new Task, 'course' => $course, 'room'=> $room,'user'=>$user,'raport'=>$raport]);
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
            'message' => 'Tugas '. $request->title . ' terupdate',
        ]);
    }
    public function generatePDF()
    {
        $raport = Raport::get();
        $data = ['title' => 'Raport', 'raport'=>$raport];
        $pdf = PDF::loadView('page.admin.raport.pdf', $data);
        return $pdf->download('raport.pdf');
    }
}
