<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Vinkla\Hashids\Facades\Hashids;

class EventController extends Controller
{
    public function create(CreateEventRequest $request)
    {


        $event = Event::create($request->all());

        if ($event) {
            return ResponseFormatter::success($event, 'Event Created');
        }

        return ResponseFormatter::error('Event Failed to Create', 404);
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $event = Event::query()->get();

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $event = Event::find($id);

            if ($event->isNotEmpty()) {
                return ResponseFormatter::success($event, 'Event Found');
            }
            return ResponseFormatter::error('Event Not Found', 404);
        }

        if ($event->isNotEmpty()) {
            return ResponseFormatter::success($event, 'Event Fetched');
        }

        return ResponseFormatter::error('Event Failed to Fetch', 404);
    }

    public function update(UpdateEventRequest $request, $id)
    {

        $id = Hashids::decode($id)[0];
        $event = Event::find($id);

        if ($event) {

            $event->update($request->all());

            return ResponseFormatter::success($event, 'Event Updated');
        }

        return ResponseFormatter::error('Event Failed to Update', 404);
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $event = Event::find($id);

        if ($event) {
            $event->delete();

            return ResponseFormatter::success($event, 'Event Deleted');
        }

        return ResponseFormatter::error(null, 'Event Failed to Delete');
    }
}
