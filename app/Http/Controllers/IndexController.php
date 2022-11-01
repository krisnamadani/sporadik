<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Data;
use App\Models\Sertipikat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
use App\Models\HasilPekerjaan;
use App\Http\Requests\DataRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('keyword') && $request->has('category')) {
            if($request->keyword != null && $request->category != null) {
                $keyword = $request->keyword;
                $category = $request->category;

                switch($category) {
                    case "1":
                        $category = "nomor_pendaftaran_permohonan";
                        $results = Data::where($category, 'like', '%' . $keyword . '%')->get();
                        break;
                    case "2":
                        $category = "nama_identitas_alamat_penerima";
                        $results = Data::where($category, 'like', '%' . $keyword . '%')->get();
                        break;
                    case "3":
                        $category = "no_seri_sertipikat";
                        $results = Data::whereHas('sertipikat', function($q) use($category, $keyword) {
                            $q->where($category, 'like', '%' . $keyword . '%');
                        })->get();
                }

                $data['results'] = $results;

                return view('index', $data);
            }
        }

        return view('index');
    }

    public function form()
    {
        $with['jenis_kegiatan'] = JenisKegiatan::latest('id')->get();

        return view('form', $with);
    }

    public function store(DataRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $validated['user_id'] = 1;
            $validated['verifikasi'] = 0;

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
}
