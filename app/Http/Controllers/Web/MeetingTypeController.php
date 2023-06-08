<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MeetingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingTypeController extends Controller
{
    public function index()
    {
        return view('meeting-type.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $meetingTypes = MeetingType::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? MeetingType::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        $meetingTypeCounter = MeetingType::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => MeetingType::count(),
            'recordsFiltered' => $meetingTypeCounter,
            'data'            => $meetingTypes,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting type failed to create'];
            $create = MeetingType::create([
                'name'        => $request['name'],
                'description' => $request['description'],
                'created_by'  => Auth::user()->id
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting type successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Meeting type failed to be found'];
            $meetingType = MeetingType::findOrFail($id);
            if ($meetingType) {
                $data = ['status' => true, 'message' => 'Meeting type was successfully found', 'data' => $meetingType];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting type failed to update'];

            $update = MeetingType::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'description' => $request['description'],
                'updated_by'  => Auth::user()->id
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting type successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Meeting type failed to delete'];

            $delete = MeetingType::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Meeting type deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
