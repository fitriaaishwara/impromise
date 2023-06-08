<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\InternalAudit;
use App\Models\InternalAuditSchedule;
use App\Models\InternalAuditScheduleAuditor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\ErrorHandler\Debug;
use Yajra\DataTables\DataTables;

class ScheduleController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $internalAudit = InternalAudit::with(['internal_audit_auditors', 'internal_audit_standards'])->where('id', $id)->firstOrFail();
        return view('internal_audit.schedule.index', compact('internalAudit'));
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

    public function dt(Request $request, $id)
    {
        $keyword = $request['searchkey'];

        $internalAudit = InternalAudit::with(['internal_audit_auditors', 'internal_audit_standards'])->where('id', $id)->firstOrFail();
        $internalAuditSchedules = InternalAuditSchedule::with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])
            ->where('internal_audit_id', $internalAudit->id)
            ->whereHas('department', function ($query) use ($keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->get();
            return DataTables::of($internalAuditSchedules)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    return $row->department->name;
                })
                ->addColumn('date', function ($row) {
                    $text = "<div style='font-weight: bold;'>Date</div>";
                    $text .= "<div>" . $this->tgl_indo(Carbon::parse($row->date)->format('d-m-Y')) . "</div>";
                    $text .= "<br>";
                    $text .= "<div style='font-weight: bold;'>Time</div>";
                    $text .= "<div>" . Carbon::parse($row->start_time)->format('H:i') . " - " . Carbon::parse($row->end_time)->format('H:i') . "</div>";

                    return $text;
                })

                ->addColumn('process', function ($row) {
                    return $row->process;
                })

                ->addColumn('auditor', function ($row) {
                    $text = "";
                    $index = 1;
                    foreach ($row->internal_audit_schedule_auditors as $auditor) {
                        $text .= "<div>" . $index++ . ". " . $auditor->user->name . "</div>";
                        // $text .= "<div>" . $auditor->user->name . "</div>";
                    }
                    return $text;
                })

                ->addColumn('action', function ($row) {
                    return '<div class = "text-center">
                    <button name="btnEdit" class="btn btn-sm btn-icon btn-warning btnEdit" data-id="'.($row->id).'" ><i class="fa fa-edit "></i></button>
                    <a href="#"class="btn btn-sm btn-icon btn-danger btnDelete " data-id="'.($row->id).'" name="btnDelete"><i class="fa fa-trash"></i></a>
                    </div>';
                })

                ->rawColumns(['date','action','auditor'])
                ->toJson();

    }

    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $departments = Department::select()
            ->with(['internal_audit_auditors', 'internal_audit_standards'])
            ->offset($request['start'])
            ->limit($request['length'] == -1 ? Department::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->oldest('name')
            ->get();

            $departmentCounter = Department::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'            => true,
            'code'              => '',
            'message'           => '',
            'draw'              => $request['draw'],
            'recordsTotal'    => Department::count(),
            'recordsFiltered' => $departmentCounter,
            'data'            => $departments,
        ];
        return $response;
    }

    public function show($id)
    {
        // dd($id);
        try {
            // $data = ['status' => false, 'message' => 'Data failed to be found'];
            $InternalAuditSchedule = InternalAuditSchedule::with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])
                ->where('id', $id)
                ->firstOrFail();
            $data = ['status' => true, 'message' => 'Data successfully found', 'data' => $InternalAuditSchedule];
            // }
        } catch (\Exception $ex) {
            // $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
            echo $ex->getMessage();
        }
        return $data;

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to create'];
            $create = InternalAuditSchedule::create([
                'internal_audit_id' => $request->internal_audit_id,
                'department_id' => $request->department_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'process' => $request->process,
            ]);

            if ($create) {
                foreach ($request['auditor_id'] as $key => $value) {
                    $createAuditor = InternalAuditScheduleAuditor::create([
                        'internal_audit_schedule_id' => $create->id,
                        'user_id' => $value,
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

    public function update(Request $request)
    {
        // dd($request->all());
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Data failed to update'];
            $update = InternalAuditSchedule::where('id', $request->id)->update([
                'internal_audit_id' => $request->internal_audit_id,
                'department_id' => $request->department_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'process' => $request->process,
            ]);

            if ($update) {
                $delete = InternalAuditScheduleAuditor::where('internal_audit_schedule_id', $request->id)->delete();
                foreach ($request['auditor_id'] as $key => $value) {
                    $updateAuditor = InternalAuditScheduleAuditor::create([
                        'internal_audit_schedule_id' => $request->id,
                        'user_id' => $value,
                    ]);
                }
                $data = ['status' => true, 'message' => 'Pengguna berhasil ditambahkan'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;

    }
    public function destroy($id)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Schedule failed to delete'];

            $delete = InternalAuditSchedule::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Schedule deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
