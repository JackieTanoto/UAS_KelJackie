<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Task;
use App\Models\Progress;
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
            return view('page.siswa.task.list', compact('collection'));
        }
        return view('page.siswa.task.main');
    }
    public function create()
    {
        $token = Auth::user()->id;
        $course = Course::where('siswa_id',$token)->get();
        return view('page.siswa.task.input', ['task' => new Task, 'course' => $course]);
    }
       public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('file')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('file'),
                ]);
            }
        }
        $file = request()->file('file')->store("progress");
        $task = new Progress;
        $task->siswa_id = Auth::user()->id;
        $task->task_id = $request->task_id;
        $task->file = $file;
        $task->uploaded_at = date("Y-m-d H:i:s");
        $task->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas '. $request->title . ' terkirim',
        ]);
    }
    public function show(Task $task)
    {
        // 
    }
    public function edit(Task $task)
    {
        $token = Auth::user()->id;
        $course = Course::where('siswa_id',$token)->get();
        return view('page.siswa.task.input', compact('task','course'));
    }
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('file')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('file'),
                ]);
            }
        }
        if(request()->file('file')){
            Storage::delete($task->file);
            $file = request()->file('file')->store("progress");
            $task->file = $file;
        }
        $task->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas terupdate',
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
    public function progress(Request $request, Task $task)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Progress::where('file','like','%'.$keywords.'%')
            ->paginate(10);
            return view('page.siswa.task.list', compact('collection'));
        }
        return view('page.siswa.task.progress', compact('task'));
    }
    public function upload(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'task_id' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('file')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('file'),
                ]);
            }
        }
        $file = request()->file('file')->store("progress");
        $task = new Progress;
        $task->siswa_id = Auth::user()->id;
        $task->task_id = $request->task_id;
        $task->file = $file;
        $task->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Tugas '. $request->title . ' terkirim',
        ]);
    }
    public function download(Task $task)
    {
        $extension = Str::of($task->file)->explode('.');
        return Storage::download($task->file, $task->due_at.'.'.$extension[1]);
    }
}
