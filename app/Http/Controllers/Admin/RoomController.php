<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $keywords = $request->keywords;
            $collection = Room::where('title','like','%'.$keywords.'%')
            ->paginate(10);
            return view('page.admin.class.list', compact('collection'));
        }
        return view('page.admin.class.main');
    }
    public function create()
    {
        return view('page.admin.class.input', ['room' => new Room]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('title')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('title'),
                ]);
            }elseif ($errors->has('year')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('year'),
                ]);
            }
        }
        $room = new Room;
        $room->title = Str::title($request->title);
        $room->year = $request->year;
        $room->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Room '. $request->title . ' tersimpan',
        ]);
    }
    public function show(Room $room)
    {
        //
    }
    public function edit(Room $room)
    {
        return view('page.admin.class.input', compact('room'));
    }
    public function update(Request $request, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('title')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('title'),
                ]);
            }elseif ($errors->has('year')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('year'),
                ]);
            }
        }
        $room->title = Str::title($request->title);
        $room->year = $request->year;
        $room->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Room '. $request->title . ' terupdate',
        ]);
    }
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Room '. $room->title . ' terhapus',
        ]);
    }
}
