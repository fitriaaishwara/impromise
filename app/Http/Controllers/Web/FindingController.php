<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InternalAudit;
use App\Models\InternalAuditFinding;
use App\Models\InternalAuditInstrument;
use App\Models\InternalAuditSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class FindingController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $internalAuditSchedules = InternalAuditSchedule::with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])->find($id);
        $internalAuditInstruments = InternalAuditInstrument::with(['internal_audit_schedule'])->where('internal_audit_schedule_id', $internalAuditSchedules->id)->find($id);
        return view('internal_audit.finding.index', compact('id', 'internalAudit', 'internalAuditInstruments'));
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
        $internalAuditSchedules = InternalAuditSchedule::with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])->where('internal_audit_id', $internalAudit->id)->firstOrFail();
        $internalAuditInstruments = InternalAuditInstrument::with(['internal_audit_schedule'])
            ->where('internal_audit_schedule_id', $internalAuditSchedules->id)
            ->whereHas('internal_audit_schedule', function ($query) use ($keyword) {
                $query->where('internal_audit_schedule_id', 'like', '%' . $keyword . '%');
            })->get();

            return DataTables::of($internalAuditInstruments)
                ->addIndexColumn()
                ->addColumn('detail', function ($row) {
                    $text = "<div style='font-weight: bold;'>Department</div>";
                    $text .= $row->internal_audit_schedule->department->name;
                    $text .= "<br>";
                    $text .= "<div style='font-weight: bold;'>Start Date - End Date</div>";
                    $text .= "<div>" . $this->tgl_indo(Carbon::parse($row->start_date)->format('d-m-Y')) . " - " . $this->tgl_indo(Carbon::parse($row->end_date)->format('d-m-Y')) . "</div>";
                    return $text;
                })
                ->addColumn('process', function ($row) {
                    return $row->internal_audit_schedule->process;
                })

                ->addColumn('clause', function ($row) {
                    return $row->clause;
                })

                ->addColumn('question', function ($row) {
                    return $row->question;
                })

                ->addColumn('observation', function ($row) {
                    return $row->observation;
                })

                ->addColumn('instrument_status', function ($row) {
                    return $row->instrument_status;
                })

                ->addColumn('finding_status', function ($row) {
                    return $row->finding_status;
                })

                ->addColumn('action', function ($row) {

                    if($row->finding_status == 1)
                    return '<div>
                    <a href="#" class="btn btn-sm btn-icon btn-dark btnEdit" data-id="'.($row->id).'" name="btnEdit"><i class="fa fa-paper-plane "></i></a>
                    </div>';
                    else if($row->finding_status == 2)
                    return '<div>
                    <a href="#" class="btn btn-sm btn-icon btn-primary btnDelete" data-id="'.($row->id).'" name="btnDelete"><i class="fa fa-eye "></i></a>
                    <a href="#" class="btn btn-sm btn-icon btn-warning btnEdit" data-id="'.($row->id).'" name="btnEdit"><i class="fa fa-edit "></i></a>
                    </div>';
                    else if($row->finding_status == 3)
                    return '<div>
                    <a href="#" class="btn btn-sm btn-icon btn-primary btnEdit" data-id="'.($row->id).'" name="btnEdit"><i class="fa fa-eye "></i></a>
                    </div>';
                })

                ->rawColumns(['detail', 'action'])
                ->toJson();
    }

    public function getData (Request $request)
    {

    }

    public function show ($id)
    {
        try {
            // $data = ['status' => false, 'message' => 'Data failed to be found'];
            $finding = InternalAuditFinding::with(['internal_audit_schedule'])
                ->where('id', $id)
                ->findOrFail($id);

            if($finding) {
                $data = ['status' => true, 'message' => 'Data was successfully found', 'data' => $finding];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

}
