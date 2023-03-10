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
        $assignedToIds = is_array($data['assigned_to']) ? $data['assigned_to'] : explode(',', $data['assigned_to']);
        $assignedTos = User::whereIn('id', $assignedToIds)->get()->pluck('email');
        foreach ($assignedTos as $email) {
            if (!Mail::to($email)->send(new ReminderMail($reminder))) {
                return ResponseFormatter::error('Reminder Failed to Create and Send Emails', 404);
            }
        }
        return ResponseFormatter::success($reminder, 'Reminder Created and Emails Sent');
    }
    public function fetch(Request $request)
    {
        $id = $request->input('id');
        $assignedTo = $request->input('assigned_to');
        $createdBy = $request->input('created_by');
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

        if ($request->has('assigned_to')) {
            $assignedTo = Hashids::decode($assignedTo);
            $reminder = $reminderQuery->where('assigned_to', $assignedTo)->get();

            if ($reminder->isNotEmpty()) {
                return ResponseFormatter::success($reminder, 'Reminder Found');
            }
            return ResponseFormatter::error('Reminder Not Found', 404);
        }

        if ($request->has('created_by')) {
            $createdBy = Hashids::decode($createdBy);
            $reminder = $reminderQuery->where('created_by', $createdBy)->get();

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
