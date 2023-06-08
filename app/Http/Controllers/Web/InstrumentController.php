<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\InternalAudit;
use App\Models\InternalAuditInstrument;
use App\Models\InternalAuditSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Alert;

class InstrumentController extends Controller
{
    public function index($id)
    {
        $internalAudit = InternalAudit::with(['internal_audit_auditors', 'internal_audit_standards'])
            ->where('id', $id)->first();
        $internalAuditSchedules = InternalAuditSchedule::with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])
            ->where('internal_audit_id', $id)->first();
        if (!$internalAudit) {
            Alert::error('Error', 'Internal Audit not found, please create internal audit first!');
            return redirect()->back();
        }
        if (!$internalAuditSchedules) {
            Alert::error('Error', 'Schedule not found, please create schedule first!');
            return redirect()->back();
        }

        return view('internal_audit.instrument.index', compact('id', 'internalAuditSchedules', 'internalAudit'));
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

        $internalAuditSchedules = InternalAuditSchedule::where('internal_audit_id', $id)->firstOrFail();
        $internalAuditInstruments = InternalAuditInstrument::with(['internal_audit_schedule'])
            ->where('internal_audit_schedule_id', $internalAuditSchedules->id)
            ->whereHas('internal_audit_schedule.department', function ($query) use ($keyword) {
                $query->when($keyword, function ($query, $keyword) {
                    return $query->where('name', 'like', '%' . $keyword . '%');
                });
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

                ->addColumn('action', function ($row) {
                    return '<div class = "text-center">
                    <a href="#" class="btn btn-sm btn-icon btn-warning btnEdit" data-id="'.($row->id).'" name="btnEdit"><i class="fa fa-edit "></i></a>
                    <a href="#"class="btn btn-sm btn-icon btn-danger btnDelete " data-id="'.($row->id).'" name="btnDelete"><i class="fa fa-trash"></i></a>
                    </div>';
                })

                ->rawColumns(['detail', 'action'])
                ->toJson();

    }

    public function getData(Request $request)
    {
        $keyword = $request['searchkey'];

        $schedule = InternalAuditSchedule::select()
            ->with(['internal_audit', 'department', 'internal_audit_schedule_auditors'])
            ->offset($request['start'])
            ->limit($request['length'] == -1 ? InternalAuditSchedule::count() : $request['length'])
            ->when($keyword, function ($query, $keyword) {
                return $query->where('internal_audit_id', 'like', '%' . $keyword . '%');
            })
            ->oldest('internal_audit_id')
            ->get();

            $scheduleCounter = InternalAuditSchedule::select()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('internal_audit_id', 'like', '%' . $keyword . '%');
            })
            ->count();

        $response = [
            'status'            => true,
            'code'              => '',
            'message'           => '',
            'draw'              => $request['draw'],
            'recordsTotal'      => InternalAuditSchedule::count(),
            'recordsFiltered'   => $scheduleCounter,
            'data'              => $schedule,
        ];
        return $response;
    }

    public function show ($id)
    {
        // dd($id);
        try {
            // $data = ['status' => false, 'message' => 'Data failed to be found'];
            $instrument = InternalAuditInstrument::with(['internal_audit_schedule.department'])
                ->where('id', $id)
                ->firstOrFail();
                // dd($instrument);
            $data = ['status' => true, 'message' => 'Data successfully found', 'data' => $instrument];
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
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Instrument failed to create'];
            $create = InternalAuditInstrument::create([
                'internal_audit_schedule_id' => $request->internal_audit_schedule_id,
                'clause' => $request->clause,
                'question' => $request->question,
                'observation' => $request->observation,
                'instrument_status' => $request->instrument_status,
            ]);

            if ($create) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Instrument successfully created'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }

    public function update(Request $request)
    {
        try {
            $data = ['status' => false, 'code' => 'EC001', 'message' => 'Instrument failed to update'];
            $update = InternalAuditInstrument::where('id', $request->id)->update([
                'internal_audit_schedule_id' => $request->internal_audit_schedule_id,
                'clause' => $request->clause,
                'question' => $request->question,
                'observation' => $request->observation,
                'instrument_status' => $request->instrument_status,
            ]);

            if ($update) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Instrument successfully updated'];
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

            $delete = InternalAuditInstrument::where('id', $id)->delete();
            if ($delete) {
                $data = ['status' => true, 'code' => 'SC001', 'message' => 'Standard deleted successfully'];
            }
        } catch (\Exception $ex) {
            $data = ['status' => false, 'code' => 'EEC001', 'message' => 'A system error has occurred. please try again later. ' . $ex];
        }
        return $data;
    }
}
