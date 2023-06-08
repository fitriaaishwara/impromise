<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('department.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $departments = Department::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Department::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        $departmentsCounter = Department::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Department::count(),
            'recordsFiltered' => $departmentsCounter,
            'data'            => $departments,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Department failed to create'];
            $create = Department::create([
                'name'        => $request['name'],
                'description' => $request['description'],
                'created_by'  => Auth::user()->id,
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Department successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Department failed to be found'];
            $department = Department::findOrFail($id);
            if ($department) {
                $data = ['status' => true, 'message' => 'Department was successfully found', 'data' => $department];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Department failed to update'];

            $update = Department::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'description' => $request['description'],
                'updated_by'  => Auth::user()->id,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Department successfully updated'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Department failed to delete'];

            $delete = Department::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Department deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
