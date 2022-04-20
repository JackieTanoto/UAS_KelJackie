<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Task;
use App\Models\Progress;
use App\Models\Room;
use App\Models\User;
use ZipArchive;
use App\Models\Raport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Task::where('title','like','%'.$keywords.'%')
            ->paginate(10);
            return view('page.guru.task.list', compact('collection'));
        }
        return view('page.guru.task.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        $room = Room::get();
        $user = User::where('role','s')->get();
        return view('page.guru.task.input', ['task' => new Task, 'course' => $course, 'room'=> $room,'user'=>$user]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'schedule' => 'required',
            'due' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('title')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('title'),
                ]);
            }elseif ($errors->has('description')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('description'),
                ]);
            }elseif ($errors->has('schedule')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('schedule'),
                ]);
            }elseif($errors->has('due')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('due'),
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('file'),
                ]);
            }
        }
        $file = request()->file('file')->store("task");
        $task = new Task;
        $task->title = Str::title($request->title);
        $task->description = Str::title($request->description);
        $task->schedule_id = $request->schedule;
        $task->due_at = $request->due;
        $task->file = $file;
        $task->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas '. $request->title . ' tersimpan',
        ]);
    }
    public function show(Task $task)
    {
        // 
    }
    public function edit(Task $task)
    {
        $token = Auth::user()->id;
        $course = Course::where('guru_id',$token)->get();
        return view('page.guru.task.input', compact('task','course'));
    }
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'schedule' => 'required',
            'due' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('title')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('title'),
                ]);
            }elseif ($errors->has('description')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('description'),
                ]);
            }elseif ($errors->has('schedule')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('schedule'),
                ]);
            }elseif($errors->has('due')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('due'),
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('file'),
                ]);
            }
        }
        if(request()->file('photo')){
            Storage::delete($task->file);
            $file = request()->file('file')->store("task");
            $task->file = $file;
        }
        $task->title = Str::title($request->title);
        $task->description = Str::title($request->description);
        $task->schedule_id = $request->schedule;
        $task->due_at = $request->due;
        $task->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas '. $request->title . ' terupdate',
        ]);
    }
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas '. $task->title . ' terhapus',
        ]);
    }
    public function download(Task $task)
    {
        $extension = Str::of($task->file)->explode('.');
        return Storage::download($task->file, $task->due_at.'.'.$extension[1]);
    }
    public function progress(Request $request, Task $task)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Progress::where('file','like','%'.$keywords.'%')->where('task_id', $task->id)
            ->paginate(10);
            return view('page.guru.task.list', compact('collection','task'));
        }
        return view('page.guru.task.progress', compact('task'));
    }
    public function downloadTugas(Task $task)
    {
        $progress = Progress::where('task_id',$task->id)->get();
        $zip_file = 'tugassiswa.zip';
        $zip = new ZipArchive;
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $progress_path = public_path('storage/progress');
        foreach($progress as $p){
            $filePath     = storage_path('app/public/'.$p->file);
            $relativePath = substr($filePath, strlen($progress_path)-4);
            $zip->addFile($filePath, $relativePath);
        }
        $zip->close();
        return response()->download($zip_file);
    }
  
}
