<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $start = $request->query('start');
        $end   = $request->query('end');

        // Validation simple des paramètres de filtre
        $hasFilter = $start && $end && strtotime($start) && strtotime($end) && $end > $start;

        $query = Room::libres()
            ->with(['photos' => fn ($q) => $q->orderBy('position')])
            ->orderBy('type')
            ->orderBy('number');

        if ($hasFilter) {
            $query->availableBetween($start, $end);
        }

        $rooms = $query->get();

        return view('client.rooms.index', compact('rooms', 'start', 'end', 'hasFilter'));
    }
    public function show(Room $room): View
    {
        $room->load(['photos' => fn ($q) => $q->orderBy('position')]);

        return view('client.rooms.show', compact('room'));
    }
}
