<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Course::where('title','like','%'.$keywords.'%')
            ->paginate(10);
            return view('page.admin.course.list', compact('collection'));
        }
        return view('page.admin.course.main');
    }
    public function create()
    {
        $guru = User::where('role','g')->get();
        return view('page.admin.course.input', ['course' => new Course, 'guru' => $guru]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'guru' => 'required',
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
            }elseif ($errors->has('guru')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('guru'),
                ]);
            }
        }
        $course = new Course;
        $course->title = Str::title($request->title);
        $course->description = Str::title($request->description);
        $course->guru_id = $request->guru;
        $course->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Pelajaran '. $request->title . ' tersimpan',
        ]);
    }
    public function show(Course $course)
    {
        //
    }
    public function edit(Course $course)
    {
        $guru = User::where('role','g')->get();
        return view('page.admin.course.input', compact('guru','course'));
    }
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'guru' => 'required',
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
            }elseif ($errors->has('guru')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('guru'),
                ]);
            }
        }
        $course->title = Str::title($request->title);
        $course->description = Str::title($request->description);
        $course->guru_id = $request->guru;
        $course->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Pelajaran '. $request->title . ' terupdate',
        ]);
    }
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Pelajaran '. $course->title . ' terhapus',
        ]);
    }
}
