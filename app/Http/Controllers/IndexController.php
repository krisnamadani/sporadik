<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;

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
                        break;
                    case "2":
                        $category = "nama_identitas_alamat_penerima";
                        break;
                    case "3":
                        $category = "no_seri_sertipikat";
                }

                $results = Data::where($category, 'like', '%' . $keyword . '%')->get();

                $data['results'] = $results;

                return view('index', $data);
            }
        }

        return view('index');
    }
}
