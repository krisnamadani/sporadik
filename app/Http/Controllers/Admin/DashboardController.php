<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Data;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $with['belum_verifikasi'] = Data::where('user_id', Auth::user()->id)->where('verifikasi', 0)->count();

        return view('admin.dashboard.index', $with);
    }

    public function data(Request $request)
    {
        if($request->ajax()) {
            $data = Data::select('*')->where('user_id', Auth::user()->id)->where('verifikasi', 0)->latest('id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown">
                        <i class="nav-icon fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="#" onClick="verification('.$row->id.')">Verifikasi</a>
                        <a class="dropdown-item" href="#" onClick="detail('.$row->id.')">Detail</a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function verification(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Data::findOrFail($request->id);
            $data->verifikasi = 1;
            $data->save();

            DB::commit();

            return $this->response(true, 'Berhasil verifikasi data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function detail(Request $request)
    {
        $data = Data::with('jenis_kegiatan', 'hasil_pekerjaan', 'sertipikat')->findOrFail($request->id);
        $data->tanda_tangan_penerima = Storage::url($data->tanda_tangan_penerima);
        return response()->json($data);
    }
}
