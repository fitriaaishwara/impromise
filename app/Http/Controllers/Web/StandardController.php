<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Standard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandardController extends Controller
{
    public function index()
    {
        return view('standard.index');
    }
    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $standards = Standard::select()
            ->offset($request['start'])
            ->limit(($request['length'] == -1) ? Standard::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->get();

        $standardsCounter = Standard::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();
        $response = [
            'status'          => true,
            'draw'            => $request['draw'],
            'recordsTotal'    => Standard::count(),
            'recordsFiltered' => $standardsCounter,
            'data'            => $standards,
        ];
        return $response;
    }
    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Standard failed to create'];
            $create = Standard::create([
                'name'        => $request['name'],
                'description' => $request['description'],
                'created_by'  => Auth::user()->id,
            ]);
            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Standard successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function show($id)
    {
        try {
            $data = ['status' => false, 'message' => 'Standard failed to be found'];
            $standard = Standard::findOrFail($id);
            if ($standard) {
                $data = ['status' => true, 'message' => 'Standard was successfully found', 'data' => $standard];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Standard failed to update'];

            $update = Standard::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'description' => $request['description'],
                'updated_by'  => Auth::user()->id,
            ]);
            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Standard successfully updated'];
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

            $delete = Standard::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Standard deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
