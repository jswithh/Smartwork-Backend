<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\CreateReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Mail\ReminderMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class ReminderController extends Controller
{
    public function create(CreateReminderRequest $request)
    {


        $data = $request->all();
        $reminder = Reminder::create($data);
        $reminderQuery = $reminder->with('reminder_type', 'created_by', 'assigned_to')->first();
        $assignedTo = User::find($reminder->assigned_to);
        $email = $assignedTo->email;

        Mail::to($email)->send(new ReminderMail($reminder));
        if ($reminder) {
            return ResponseFormatter::success($reminder, 'Reminder Created');
        }

        return ResponseFormatter::error('Reminder Failed to Create', 404);
    }

    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);

        // get multiple data
        $reminderQuery = Reminder::query()->with('reminder_type', 'created_by', 'assigned_to');

        // get single data

        if ($request->has('id')) {
            $id = Hashids::decode($id);
            $reminder = $reminderQuery->where('id', $id)->get();

            if ($reminder->isNotEmpty()) {
                return ResponseFormatter::success($reminder, 'Reminder Found');
            }
            return ResponseFormatter::error('Reminder Not Found', 404);
        }
        $reminder = $reminderQuery->paginate($limit);
        if ($reminder->isNotEmpty()) {
            return ResponseFormatter::success($reminder, 'Reminder Found');
        }
        return ResponseFormatter::error('Reminder Not Found', 404);
    }

    public function update(UpdateReminderRequest $request, $id)
    {


        $id = Hashids::decode($id)[0];
        $reminder = Reminder::find($id);

        if ($reminder) {
            $reminder->update(
                $request->all()
            );

            return ResponseFormatter::success($reminder, 'Reminder Updated');
        }

        return ResponseFormatter::error(null, 'Reminder Failed to Update');
    }

    public function delete($id)
    {
        $id = Hashids::decode($id)[0];
        $reminder = Reminder::find($id);

        if ($reminder) {
            $reminder->delete();

            return ResponseFormatter::success($reminder, 'Reminder Deleted');
        }

        return ResponseFormatter::error('Reminder Failed to Delete', 404);
    }
}
