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
            $numberOfRooms = $this->getNumberOfRooms();

            return view('rooms.master')->with('numberOfRooms', $numberOfRooms);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function detailRooms($type)
    {
        if (Auth::user()->can('Manage Room')) {
            $rooms = Room::where('type', $type)->where('created_by', '=', Auth::user()->getCreatedBy())->orderBy('id', 'ASC')->get();
            return view('rooms.index', compact('rooms', 'type'));
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

    public function createRoom($type)
    {
        if (Auth::user()->can('Create Room')) {
            $roomTypes = [
                'hall' => 'HALL',
                'room' => 'ROOM',
                'vip' => 'VIP',
            ];

            $lastNumber = $this->getLastNumber($type);

            $room = new Room();
            $room->code = $roomTypes[$type] . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);  // e.g., HALL-004
            $room->type = $type;
            $room->created_by = Auth::user()->getCreatedBy();
            $room->is_active = '1';
            $room->save();

            return redirect()->back()->with('success', __('Room added successfully.'));
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
                    'type' => 'required',
                    'price' => 'required|numeric',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $user = User::where('id', '=', Auth::user()->getCreatedBy())->first();


            $room['room_code'] = $request->room_code;
            $room['type'] = $request->room_type;
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
                    'code' => 'required|max:120',
                    'status' => 'required',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $room['code'] = $request->code;
            $room['status'] = $request->status;
            $room->save();

            return redirect()->back()->with('success', __('Room updated successfully.'));
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

    public function numberOfRoomUpdate(Request $request)
    {
        $numberOfRooms = $this->getNumberOfRooms();

        // Define room types and their prefixes
        $roomTypes = [
            'hall' => 'HALL',
            'room' => 'ROOM',
            'vip' => 'VIP',
        ];

        foreach ($roomTypes as $type => $prefix) {
            if ($request->has($type)) {
                $newRoomCount = $request->$type - $numberOfRooms->$type;

                if ($newRoomCount > 0) {
                    // Add rooms
                    for ($i = 1; $i <= $newRoomCount; $i++) {
                        $lastNumber = $this->getLastNumber($type);

                        $room = new Room();
                        $room->code = $prefix . '-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);  // e.g., HALL-004
                        $room->type = $type;
                        $room->created_by = Auth::user()->getCreatedBy();
                        $room->is_active = '1';
                        $room->save();
                    }
                } elseif ($newRoomCount < 0) {
                    // Remove rooms in reverse order
                    $roomsToDelete = Room::where('created_by', Auth::user()->getCreatedBy())
                                        ->where('type', $type)
                                        ->orderBy('code', 'desc')
                                        ->take(abs($newRoomCount))
                                        ->get();

                    foreach ($roomsToDelete as $room) {
                        $room->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', __('Room numbers updated successfully.'));
    }

    public function getNumberOfRooms()
    {
        $numberOfRooms = new \stdClass();

        $numberOfRooms->hall = Room::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'hall')
                                ->count();

        $numberOfRooms->room = Room::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'room')
                                ->count();

        $numberOfRooms->vip = Room::where('created_by', Auth::user()->getCreatedBy())
                                ->where('type', 'vip')
                                ->count();

        return $numberOfRooms;
    }

    public function getLastNumber($type)
    {
        // Get the last room code based on type and created_by
        $lastRoom = Room::where('created_by', Auth::user()->getCreatedBy())
                        ->where('type', $type)
                        ->orderByDesc('code')
                        ->first();

        // Extract and return the numeric part if it exists, otherwise return 0
        if ($lastRoom && preg_match('/(\d+)$/', $lastRoom->code, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }
}
