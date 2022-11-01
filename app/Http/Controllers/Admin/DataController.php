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
use App\Models\HasilPekerjaan;
use App\Models\JenisKegiatan;
use App\Models\Sertipikat;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class DataController extends Controller
{
    public function index()
    {
        $with['jenis_kegiatan'] = JenisKegiatan::where('user_id', Auth::user()->id)->latest('id')->get();

        return view('admin.data.index', $with);
    }

    public function data(Request $request)
    {
        if($request->ajax()) {
            $data = Data::select('*')->where('user_id', Auth::user()->id)->where('verifikasi', 1)->latest('id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('jenis_kegiatan_id', function($row) {
                    return $row->jenis_kegiatan->nama_kegiatan;
                })
                ->addColumn('action', function($row) {
                    return '<button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown">
                        <i class="nav-icon fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="#" onClick="detail('.$row->id.')">Detail</a>
                        <a class="dropdown-item" href="#" onClick="edit('.$row->id.')">Edit</a>
                        <a class="dropdown-item" href="#" onClick="remove('.$row->id.')">Hapus</a>
                    </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function add()
    {
        $with['jenis_kegiatan'] = JenisKegiatan::where('user_id', Auth::user()->id)->latest('id')->get();

        return view('admin.data.add', $with);
    }

    public function detail(Request $request)
    {
        $data = Data::with('jenis_kegiatan', 'hasil_pekerjaan', 'sertipikat')->findOrFail($request->id);
        $data->tanda_tangan_penerima = Storage::url($data->tanda_tangan_penerima);
        return response()->json($data);
    }

    public function store(DataRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $validated['user_id'] = Auth::user()->id;
            $validated['verifikasi'] = 1;

            if($request->has('tanda_tangan_penerima')) {
                $tanda_tangan_penerima = $request->file('tanda_tangan_penerima');
                $tanda_tangan_penerima_name = Str::slug($validated['nomor_pendaftaran_permohonan']);
                $tanda_tangan_penerima_path = 'public/user/data/'.$tanda_tangan_penerima_name.'.webp';
                $tanda_tangan_penerima_conversion = Image::make($tanda_tangan_penerima)->encode('webp');
                
                Storage::put($tanda_tangan_penerima_path, $tanda_tangan_penerima_conversion);

                $validated['tanda_tangan_penerima'] = $tanda_tangan_penerima_path;
            }

            $data = Data::create($validated);

            foreach($validated['hasil_pekerjaan_yang_diterima'] as $item) {
                HasilPekerjaan::create([
                    'data_id' => $data->id,
                    'hasil_pekerjaan_yang_diterima' => $item
                ]);
            }

            foreach($validated['no_seri_sertipikat'] as $item) {
                Sertipikat::create([
                    'data_id' => $data->id,
                    'no_seri_sertipikat' => $item
                ]);
            }
            
            DB::commit();

            return $this->response(true, 'Berhasil menambah data');
        } catch (Exception $e) {
            DB::rollback();

            return $this->response(false, $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $data = Data::with('hasil_pekerjaan', 'sertipikat')->findOrFail($request->id);

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
            
            $data->hasil_pekerjaan()->delete();
            $data->sertipikat()->delete();

            foreach($validated['hasil_pekerjaan_yang_diterima'] as $item) {
                HasilPekerjaan::create([
                    'data_id' => $data->id,
                    'hasil_pekerjaan_yang_diterima' => $item
                ]);
            }

            foreach($validated['no_seri_sertipikat'] as $item) {
                Sertipikat::create([
                    'data_id' => $data->id,
                    'no_seri_sertipikat' => $item
                ]);
            }

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
            $data->hasil_pekerjaan()->delete();
            $data->sertipikat()->delete();
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
