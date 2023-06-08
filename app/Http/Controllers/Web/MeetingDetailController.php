<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MeetingDetail;
use Illuminate\Http\Request;

class MeetingDetailController extends Controller
{
    public function getData(Request $request)
    {
        $keyword      = $request['searchkey'];
        $temporary_id = $request['temporary_id'];
        $meeting_id   = $request['meeting_id'];

        $allMeetingDetails = MeetingDetail::select()
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->count();

        $meetingDetails = MeetingDetail::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? $allMeetingDetails : $request['length'])
            ->with(['departments', 'users'])
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where('topic', 'like', '%' . $keyword . '%');
            })
            ->get();

        $meetingDetailCounter = MeetingDetail::select()
            ->when($meeting_id, function ($query, $meeting_id) {
                return $query->where('meeting_id', $meeting_id);
            })
            ->when($temporary_id, function ($query, $temporary_id) {
                return $query->where('temporary_id', $temporary_id);
            })
            ->when($keyword, function ($query, $keyword) {
                return $query->where('topic', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => $allMeetingDetails,
            'recordsFiltered' => $meetingDetailCounter,
            'data'            => $meetingDetails,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to create'];
            $create = MeetingDetail::create([
                'meeting_id'    => ($request['meeting_id']) ? $request['meeting_id'] : null,
                'temporary_id'  => ($request['temporary_id']) ? $request['temporary_id'] : null,
                'department_id' => $request['department_id'],
                'user_id'       => $request['user_id'],
                'discussion'    => $request['discussion'],
                'pic'           => $request['pic'],
                'due_date'      => $request['due_date'],
                'last_status'   => $request['last_status'],
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Meeting failed to be found'];
            $meetingDetail = MeetingDetail::with(['departments', 'users'])->where('id', $id)->firstOrFail();
            if ($meetingDetail) {
                $data = ['status' => true, 'message' => 'Meeting was successfully found', 'data' => $meetingDetail];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to update'];

            $update = MeetingDetail::where('id', $request['id'])->update([
                'department_id' => $request['department_id'],
                'user_id'       => $request['user_id'],
                'discussion'    => $request['discussion'],
                'pic'           => $request['pic'],
                'due_date'      => $request['due_date'],
                'last_status'   => $request['last_status'],
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to delete'];

            $delete = MeetingDetail::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
