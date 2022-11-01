<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Requests\JenisKegiatanRequest;

class JenisKegiatanController extends Controller
{
    public function index()
    {
        return view('admin.jenis_kegiatan.index');
    }

    public function data(Request $request)
    {
        if($request->ajax()) {
            $jenis_kegiatan = JenisKegiatan::select('*')->where('user_id', Auth::user()->id)->latest('id');

            return DataTables::of($jenis_kegiatan)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown">
                        <i class="nav-icon fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="#" onClick="edit('.$row->id.')">Edit</a>
                        <a class="dropdown-item" href="#" onClick="remove('.$row->id.')">Hapus</a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function detail(Request $request)
    {
        return response()->json(JenisKegiatan::findOrFail($request->id));
    }

    public function store(JenisKegiatanRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $validated['user_id'] = Auth::user()->id;

            JenisKegiatan::create($validated);
            DB::commit();

            return $this->response(true, 'Berhasil menambah jenis kegiatan');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $jenis_kegiatan = JenisKegiatan::findOrFail($request->id);

        return response()->json($jenis_kegiatan);
    }

    public function update(JenisKegiatanRequest $request)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();

        try {
            $jenis_kegiatan = JenisKegiatan::findOrFail($request->id);

            $jenis_kegiatan->update($validated);

            DB::commit();

            return $this->response(true, 'Berhasil mengubah jenis kegiatan');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $jenis_kegiatan = JenisKegiatan::findOrFail($request->id);
            $jenis_kegiatan->delete();

            DB::commit();

            return $this->response(true, 'Berhasil menghapus jenis kegiatan');
        } catch (QueryException $e) {
            DB::rollback();

            return $this->response(false, 'Gagal menghapus jenis kegiatan');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }
}
