<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        if (Auth::user()->can('Manage Room')) {
            $rooms = Room::where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'DESC')->get();

            return view('rooms.index')->with('rooms', $rooms);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (Auth::user()->can('Create Room')) {
            return view('rooms.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Room')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'room_code' => 'required|max:120',
                    'room_type' => 'required',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();


            $room['room_code'] = $request->room_code;
            $room['room_type'] = $request->room_type;
            $room['price'] = $request->price;
            $room['is_active'] = 1;
            $room['created_by'] = $user->getCreatedBy();

            $room = Room::create($room);

            return redirect()->route('rooms.index')->with('success', __('Room added successfully.'));
             
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Room $room)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Room $room)
    {
        if (Auth::user()->can('Edit Room')) {
            return view('rooms.edit', compact('room'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Room $room)
    {
        if (Auth::user()->can('Edit Room')) {
            $validator = Validator::make(
                $request->all(),
                [
                   'room_code' => 'required|max:120',
                    'room_type' => 'required',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $room['room_code'] = $request->room_code;
            $room['room_type'] = $request->room_type;
            $room['price'] = $request->price;
            $room['is_active'] = 1;
            $room->save();

            return redirect()->route('rooms.index')->with('success', __('Room updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Room $room)
    {
        if (Auth::user()->can('Delete Room')) {
            $room->delete();

            return redirect()->route('rooms.index')->with('success', __('Room successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
