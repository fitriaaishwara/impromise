<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function index()
    {
        return view('issue.index');
    }

    public function getDataInternal(Request $request)
    {
        $keyword = $request['searchkey'];

        $issueInternals = Issue::where('type', 1)
            ->select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Issue::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('dimension', 'like', '%' . $keyword . '%');
            })
            ->get();

        $issueInternalsCounter = Issue::where('type', 'internal')
            ->select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('dimension', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Issue::count(),
            'recordsFiltered' => $issueInternalsCounter,
            'data'            => $issueInternals,
        ];
        return $response;
    }

    public function getDataExternal(Request $request)
    {
        $keyword = $request['searchkeyEks'];

        $issueInternals = Issue::where('type', 2)
            ->select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Issue::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('dimension', 'like', '%' . $keyword . '%');
            })
            ->get();

        $issueInternalsCounter = Issue::where('type', 'internal')
            ->select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('dimension', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Issue::count(),
            'recordsFiltered' => $issueInternalsCounter,
            'data'            => $issueInternals,
        ];
        return $response;
    }

    public function store(Request $request)
    {
        try{
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Issue failed to create'];
            $create = Issue::create([
                'dimension' => $request['dimension'],
                'type' => $request['type'],
                'issue' => $request['issue'],
                'created_by' => Auth::user()->id,
            ]);
            if($create){
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Issue successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function show($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Issue failed to show'];
            $issue = Issue::findOrFail($id);
            if ($issue) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Issue successfully show', 'data' => $issue];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Standard failed to delete'];

            $delete = Issue::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Standard deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Issue failed to update'];
            $update = Issue::where('id', $request['id'])->update([
                'dimension' => $request['dimension'],
                'type' => $request['type'],
                'issue' => $request['issue'],
                'updated_by' => Auth::user()->id,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Issue successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
