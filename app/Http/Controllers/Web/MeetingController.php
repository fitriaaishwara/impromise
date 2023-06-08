<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetingParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function index()
    {
        return view('meeting.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];
        $meetings = Meeting::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Meeting::count() : $request['length'])
            ->with('meeting_type', 'meeting_participants.department', 'meeting_participants.user')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('agenda', 'like', '%' . $keyword . '%');
            })
            ->withCount([
                'meeting_details AS meeting_open' => function ($query) {
                    $query->where('status', false);
                }
            ])
            ->withCount([
                'meeting_details AS meeting_close' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->latest()
            ->get();

        $meetingsCounter = Meeting::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('agenda', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Meeting::count(),
            'recordsFiltered' => $meetingsCounter,
            'data'            => $meetings,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to create'];
            $create = Meeting::create([
                'meeting_type_id'      => $request['meeting_type_id'],
                'participant'          => $request['participant'],
                'agenda'               => $request['agenda'],
                'date'                 => $request['date'],
                'start_time'           => $request['start_time'],
                'end_time'             => $request['end_time'],
                'location'             => $request['location'],
                'created_by'           => Auth::user()->id,
            ]);
            if ($create) {
                if ($request['participant'] == '2') {
                    foreach ($request['department_id'] as $key => $value) {
                        MeetingParticipant::create([
                            'meeting_id'    => $create->id,
                            'department_id' => $value
                        ]);
                    }
                } elseif ($request['participant'] == '3') {
                    foreach ($request['user_id'] as $key => $value) {
                        MeetingParticipant::create([
                            'meeting_id'    => $create->id,
                            'user_id'       => $value
                        ]);
                    }
                }
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Meeting failed to be found'];
            $meeting = Meeting::with(['meeting_participants.department', 'meeting_participants.user', 'meeting_type'])->where('id', $id)->firstOrFail();
            if ($meeting) {
                $data = ['status' => true, 'message' => 'Meeting was successfully found', 'data' => $meeting];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to create'];
            $update = Meeting::where('id', $request['id'])->update([
                'meeting_type_id'      => $request['meeting_type_id'],
                'participant'          => $request['participant'],
                'agenda'               => $request['agenda'],
                'date'                 => $request['date'],
                'start_time'           => $request['start_time'],
                'end_time'             => $request['end_time'],
                'location'             => $request['location'],
                'updated_by'           => Auth::user()->id,
            ]);
            if ($update) {
                $deleteParticipant = MeetingParticipant::where('meeting_id', $request['id'])->delete();
                if ($request['participant'] == '2') {
                    foreach ($request['department_id'] as $key => $value) {
                        MeetingParticipant::create([
                            'meeting_id'    => $request['id'],
                            'department_id' => $value
                        ]);
                    }
                } elseif ($request['participant'] == '3') {
                    foreach ($request['user_id'] as $key => $value) {
                        MeetingParticipant::create([
                            'meeting_id'    => $request['id'],
                            'user_id'       => $value
                        ]);
                    }
                }
                DB::commit();
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollback();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function mom($id)
    {
        return view('meeting.mom', compact('id'));
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting failed to delete'];

            $delete = Meeting::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
