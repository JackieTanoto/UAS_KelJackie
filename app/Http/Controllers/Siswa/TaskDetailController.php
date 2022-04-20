<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\TaskDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TaskDetailController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required',
            'due' => 'required',
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('task')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('task'),
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
        $task_detail = new TaskDetail;
        $task_detail->task_id = $request->task;
        $task_detail->due_at = $request->due;
        $task_detail->file = $file;
        $task_detail->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'File terupload',
        ]);
    }
    public function show(TaskDetail $taskDetail)
    {
        //
    }
    public function edit(TaskDetail $taskDetail)
    {
        //
    }
    public function update(Request $request, TaskDetail $taskDetail)
    {
        $validator = Validator::make($request->all(), [
            'task' => 'required',
            'due' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('task')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('task'),
                ]);
            }elseif($errors->has('due')){
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('due'),
                ]);
            }
        }
        if(request()->file('photo')){
            Storage::delete($taskDetail->file);
            $file = request()->file('file')->store("task");
            $taskDetail->file = $file;
        }
        $taskDetail->task_id = $request->task;
        $taskDetail->due_at = $request->due;
        $taskDetail->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'File terupdate',
        ]);
    }
    public function destroy(TaskDetail $taskDetail)
    {
        //
    }
    public function download(TaskDetail $taskDetail)
    {
        $extension = Str::of($taskDetail->file)->explode('.');
        return Storage::download($taskDetail->file, $taskDetail->due_at.'.'.$extension[1]);
    }
}
