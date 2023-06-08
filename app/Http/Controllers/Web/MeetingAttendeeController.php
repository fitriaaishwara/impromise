<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MeetingAttendee;
use Illuminate\Http\Request;

class MeetingAttendeeController extends Controller
{
    public function getData(Request $request)
    {
        $keyword      = $request['searchkey'];
        $temporary_id = $request['temporary_id'];
        $meeting_id   = $request['meeting_id'];

        $allMeetingAttendees = MeetingAttendee::select()
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->count();

        $meetingAttendees = MeetingAttendee::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allMeetingAttendees : $request['length'])
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        $meetingAttendeeCounter = MeetingAttendee::select()
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $allMeetingAttendees,
            'recordsFiltered' => $meetingAttendeeCounter,
            'data'            => $meetingAttendees,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting attendee failed to create'];
            $create = MeetingAttendee::create([
                'meeting_id'   => ($request['meeting_id']) ? $request['meeting_id'] : null,
                'temporary_id' => ($request['temporary_id']) ? $request['temporary_id'] : null,
                'name'         => $request['name'],
                'role'         => $request['role'],
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting attendee successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Meeting attendee failed to be found'];
            $meetingAttendee = MeetingAttendee::where('id', $id)->firstOrFail();
            if ($meetingAttendee) {
                $data = ['status' => true, 'message' => 'Meeting attendee was successfully found', 'data' => $meetingAttendee];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting attendee failed to update'];

            $update = MeetingAttendee::where('id', $request['id'])->update([
                'name' => $request['name'],
                'role' => $request['role'],
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting attendee successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting attendee failed to delete'];

            $delete = MeetingAttendee::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting attendee deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
