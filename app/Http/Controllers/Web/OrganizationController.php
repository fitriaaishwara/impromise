<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationStandard;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;

class OrganizationController extends Controller
{
    public function index()
    {
        //checked data exist or not
        $organizationStandard = OrganizationStandard::with('organization', 'standard')->first();
        // dd($organization);
        if ($organizationStandard) {
            return view('organization.index', compact('organizationStandard'));
        } else {
            return view('organization.index', compact('organizationStandard'));
        }
    }

    public function store(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Organization failed to create'];
            $fileName = Str::random(10);
            $fileName2 = Str::random(10);
            $path = 'structure/' . $request['id'];
            $path2 = 'business_process/' . $request['id'];


            $validator = Validator::make($request->all(), [
                'structure' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
                'business_process' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
            }

            $extension = $request->file('structure')->extension();
            $extension2 = $request->file('business_process')->extension();
            Storage::disk('public')->putFileAs($path, $request->file('structure'), $fileName . '.' . $extension);
            Storage::disk('public')->putFileAs($path2, $request->file('business_process'), $fileName2 . '.' . $extension2);
            $create = Organization::create([
                'name'        => $request['name'],
                'address'     => $request['address'],
                'structure'   => $fileName . '.' . $extension,
                'business_process' => $fileName2 . '.' . $extension2,
                'created_by'  => Auth::user()->id,
            ]);
            if ($create) {
                $createOrganizationStandard = OrganizationStandard::create([
                    'organization_id' => $create->id,
                    'standard_id'     => $request['standard_id'],
                    'scope'           => $request['scope'],
                    'created_by'      => Auth::user()->id,
                ]);
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function edit($id)
    {
        return view('organization.edit', compact('id'));
    }

    public function show($id)
    {

        try {
            $data = ['status' => false, 'message' => 'Organization failed to be found'];
            $organization = OrganizationStandard::with('organization', 'standard')->where('organization_id', $id)->first();
            if ($organization) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully show', 'data' => $organization];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function create()
    {
        return view('organization.create');
    }

    public function update(Request $request)
    {
        $fileName = Str::random(10);
        $fileName2 = Str::random(10);
        $path = 'structure/';
        $path2 = 'business_process/';
        $organization = Organization::where('id', $request['id'])->first();
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Organization failed to update'];
            $validator = Validator::make($request->all(), [
                'structure' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
                'business_process' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,png,jpg,jpeg,rar,zip|max:10240',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'code' => 'EC001', 'message' => 'The maximum file size is 10 MB with the format PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV, PNG, JPG, JPEG, RAR, ZIP.']);
            }
            if ($request->file('structure') != null) {
                $extension = $request->file('structure')->extension();
                $structure = $fileName . '.' . $extension;
                Storage::disk('public')->putFileAs($path, $request->file('structure'), $fileName . '.' . $extension);
            } else {
                $structure = null;
            }

            if ($request->file('business_process') != null) {
                $extension2 = $request->file('business_process')->extension();
                $business_process = $fileName2 . '.' . $extension2;
                Storage::disk('public')->putFileAs($path2, $request->file('business_process'), $fileName2 . '.' . $extension2);
            } else {
                $business_process = null;
            }

            $update = Organization::where('id', $request['id'])->update([
                'name'        => $request['name'],
                'address'     => $request['address'],
                'structure'   => $structure != null ? $structure : $organization->structure,
                'business_process' => $business_process != null ? $business_process : $organization->business_process,
                'updated_by'  => Auth::user()->id,
            ]);

            if ($update) {
                $updateOrganizationStandard = OrganizationStandard::where('organization_id', $request['id'])->update([
                    'standard_id'     => $request['standard_id'],
                    'scope'           => $request['scope'],
                    'updated_by'      => Auth::user()->id,
                ]);
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully updated'];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
