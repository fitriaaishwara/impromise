<?php

namespace App\Http\Controllers\Web;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\InternalAudit;
use App\Models\InternalAuditAuditor;
use App\Models\InternalAuditStandard;
use App\Models\Standard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InternalAuditController extends Controller
{
    public function index()
    {
        return view('internal_audit.index');
    }

    function tgl_indo($tanggal = null)
    {
        if ($tanggal == null) {
            $tanggal = date('d-m-Y');
        }

        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
    }

    public function dt(Request $request)
    {
        $keyword = $request['searchkey'];

        $internalAudit = InternalAudit::with(['internal_audit_auditors', 'internal_audit_standards'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->oldest('name')
            ->get();

            return DataTables::of($internalAudit)
                ->addIndexColumn()
                ->addColumn('standard', function ($row) {

                    $standardId = $row->internal_audit_standards[0]->standard_id;
                    return InternalAuditStandard::with('standard')->where('standard_id', $standardId)->first()->standard->name;
                })
                ->addColumn('auditor', function ($row) {
                    $text = '';
                    $index = 1;
                    foreach ($row->internal_audit_auditors as $auditor) {
                        $text .= "<div>" . $index++ . ". " . $auditor->user->name . "</div>";
                    }
                    return $text;
                })

                ->addColumn('date', function ($row){
                    $text = "<div style='font-weight: bold;'>Start Date</div>";
                    $text .= "<div>" . $this->tgl_indo(Carbon::parse($row->start_date)->format('d-m-Y')) . "</div>";
                    $text .= "<br>";
                    $text .= "<div style='font-weight: bold;'>End Date</div>";
                    $text .= "<div>" . $this->tgl_indo(Carbon::parse($row->end_date)->format('d-m-Y')) . "</div>";

                    return $text;
                })

                ->addColumn('schedule', function ($row){
                    return '<div><a href="'.url('schedule/'. $row->id).'" class="btn btn-dark btn-icon btn-sm" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-paper-plane"></i></a></div>';
                })

                ->addColumn('instrument', function ($row){
                    return '<div><a href="'.url('instrument/'. $row->id).'" class="btn btn-dark btn-icon btn-sm"><i class="fa fa-paper-plane"></i></a></div>';
                })

                ->addColumn('finding', function ($row){
                    return '<div><a href="'.url('finding/'. $row->id).'" class="btn btn-dark btn-icon btn-sm"><i class="fa fa-paper-plane"></i></a></div>';
                })

                ->addColumn('action', function ($row) {
                    return '<div class = "text-center">
                    <a href="'.url('internal-audit/detail/'. $row->id).'" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-eye"></i></a>
                    <a href="'.url('internal-audit/edit/'. $row->id).'" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-edit "></i></a>
                    <a href="#" class="btnDelete btn btn-sm btn-icon btn-danger" data-id="'.($row->id).'" name="btnDelete"><i class="fa fa-trash"></i></a>
                    </div>';
                })
                ->rawColumns(['date','schedule', 'instrument', 'finding', 'action','auditor'])
                ->toJson();
    }

    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $internalAudit = InternalAudit::select()
            ->with(['internal_audit_auditors', 'internal_audit_standards'])
            ->offset($request['start'])
            ->limit($request['length'] == -1 ? InternalAudit::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->oldest('name')
            ->get();

        $internalAuditCounter = InternalAudit::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'            => true,
            'code'              => '',
            'message'           => '',
            'draw'              => $request['draw'],
            'recordsTotal'      => InternalAudit::count(),
            'recordsFiltered'   => $internalAuditCounter,
            'data'              => $internalAudit,
        ];
        return $response;
    }

    public function detail($id)
    {
        // dd($id);
        $internalAudit = InternalAudit::with(['internal_audit_auditors', 'internal_audit_standards'])->where('id', $id)->firstOrFail();
        return view('internal_audit.detail', compact('id', 'internalAudit'));
    }
    public function create()
    {
        $standard = Standard::orderBy('id', 'ASC')->get();

        $groupStandard = [];
        foreach ($standard as $row) {
            $groupName = $row->group_standard;
            $groupStandard[$groupName][] = $row;
        }

        $user = User::orderBy('id', 'ASC')->get();

        $groupUser = [];
        foreach ($user as $row) {
            $groupNameUser = $row->group_user;
            $groupUser[$groupNameUser][] = $row;
        }

        return view('internal_audit.create', compact('groupStandard', 'groupUser'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request['role']['5a211e55-71e2-429d-bd2a-cf06dd178fd5']);

        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $create = InternalAudit::create([
                'name'          => $request['name'],
                'start_date'   => $request['start_date'],
                'end_date'     => $request['end_date'],
                'location'     => $request['location'],
                'note'         => $request['note'],
                'created_by'   => Auth::user()->id,
            ]);

            if ($create) {
                foreach ($request['standard'] as $key => $value) {
                    $createStandardAudit = InternalAuditStandard::create([
                        'internal_audit_id' => $create->id,
                        'standard_id'       => $value,
                    ]);
                }
                foreach ($request['groupUser'] as $key => $value) {
                    $createAuditAuditor = InternalAuditAuditor::create([
                        'internal_audit_id' => $create->id,
                        'user_id'           => $value,
                        'role'              => $request['role'][$value],
                    ]);
                }

                DB::commit();
                        $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully created'];
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }

        return $data;
    }

    public function show($id)
    {
        // dd($id);
        try {
            // $data = ['status' => false, 'message' => 'Data failed to be found'];
            $InternalAudit = InternalAudit::with(['internal_audit_auditors.user', 'internal_audit_standards.standard'])
                ->where('id', $id)
                ->firstOrFail();
            $data = ['status' => true, 'message' => 'Data successfully found', 'data' => $InternalAudit];
            // }
        } catch (\Exception $ex) {
            // $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
            echo $ex->getMessage();
        }
        return $data;

    }

    public function edit($id)
    {

        $standard = Standard::orderBy('id', 'ASC')->get();

        $groupStandard = [];
        foreach ($standard as $row) {
            $groupName = $row->group_standard;
            $groupStandard[$groupName][] = $row;
        }

        $user = User::orderBy('id', 'ASC')->get();

        $groupUser = [];
        foreach ($user as $row) {
            $groupNameUser = $row->group_user;
            $groupUser[$groupNameUser][] = $row;
        }
        // dd($id);
        return view('internal_audit.edit', compact('id', 'groupStandard', 'groupUser'));
    }
    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];

            $update = InternalAudit::where('id', $request['id'])->update([
                'name'          => $request['name'],
                'start_date'   => $request['start_date'],
                'end_date'     => $request['end_date'],
                'location'     => $request['location'],
                'note'         => $request['note'],
                'updated_by'   => Auth::user()->id,
            ]);

            if ($update) {
                foreach ($request['standard'] as $key => $value) {
                    $createStandardAudit = InternalAuditStandard::updateOrCreate([
                        'internal_audit_id' => $request['id'],
                        'standard_id'       => $value,
                    ]);
                }
                foreach ($request['groupUser'] as $key => $value) {
                    $createAuditAuditor = InternalAuditAuditor::updateOrCreate([
                        'internal_audit_id' => $request['id'],
                        'user_id'           => $value,
                        'role'              => $request['role'][$value],
                    ]);
                }
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data successfully created'];
            }
        }   catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to delete'];

            $delete = InternalAudit::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Data deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
