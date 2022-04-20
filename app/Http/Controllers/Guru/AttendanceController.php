<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function index(Request $request, Schedule $schedule)
    {
        if ($request->ajax()) {
            $collection = Attendance::where('schedule_id',$schedule->id)
            ->paginate(10);
            return view('page.guru.attendance.list', compact('collection'));
        }
        return view('page.guru.attendance.main',compact('schedule'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show(Attendance $attendance)
    {
        //
    }
    public function edit(Attendance $attendance)
    {
        return view('page.guru.attendance.input', compact('attendance'));
    }
    public function update(Request $request, Attendance $attendance)
    {
        $validator = Validator::make($request->all(), [
            'st' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('st')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('st'),
                ]);
            }
        }
        $attendance->st = $request->st;
        $attendance->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Absensi terupdate',
        ]);
    }
    public function destroy(Attendance $attendance)
    {
        //
    }
}
