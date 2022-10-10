<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Data;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\DataRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function index()
    {
        return view('admin.data.index');
    }

    public function data(Request $request)
    {
        if($request->ajax()) {
            $data = Data::select('*')->where('user_id', Auth::user()->id)->latest('id');

            return DataTables::of($data)
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
        return response()->json(Data::findOrFail($request->id));
    }

    public function store(DataRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $validated['user_id'] = Auth::user()->id;

            if($request->has('tanda_tangan_penerima')) {
                $tanda_tangan_penerima = $request->file('tanda_tangan_penerima');
                $tanda_tangan_penerima_name = Str::slug($validated['nomor_pendaftaran_permohonan']);
                $tanda_tangan_penerima_path = 'public/user/data/'.$tanda_tangan_penerima_name.'.webp';
                $tanda_tangan_penerima_conversion = Image::make($tanda_tangan_penerima)->encode('webp');
                
                Storage::put($tanda_tangan_penerima_path, $tanda_tangan_penerima_conversion);

                $validated['tanda_tangan_penerima'] = $tanda_tangan_penerima_path;
            }

            Data::create($validated);
            DB::commit();

            return $this->response(true, 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $data = Data::findOrFail($request->id);

        return response()->json($data);
    }

    public function update(DataRequest $request)
    {
        $validated = $request->validated();
        
        DB::beginTransaction();

        try {
            $data = Data::findOrFail($request->id);

            if($request->has('tanda_tangan_penerima')) {
                if($data->tanda_tangan_penerima != null) {
                    Storage::delete($data->tanda_tangan_penerima);
                }

                $tanda_tangan_penerima = $request->file('tanda_tangan_penerima');
                $tanda_tangan_penerima_name = Str::slug($validated['nomor_pendaftaran_permohonan']);
                $tanda_tangan_penerima_path = 'public/user/data/'.$tanda_tangan_penerima_name.'.webp';
                $tanda_tangan_penerima_conversion = Image::make($tanda_tangan_penerima)->encode('webp');
                
                Storage::put($tanda_tangan_penerima_path, $tanda_tangan_penerima_conversion);

                $validated['tanda_tangan_penerima'] = $tanda_tangan_penerima_path;
            }
            
            $data->update($validated);

            DB::commit();

            return $this->response(true, 'Berhasil mengubah data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = Data::findOrFail($request->id);
            $data->delete();

            DB::commit();
            Storage::delete($data->tanda_tangan_penerima);

            return $this->response(true, 'Berhasil menghapus data');
        } catch (QueryException $e) {
            DB::rollback();

            return $this->response(false, 'Gagal menghapus data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }
}
