<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->isMethod('post')) {
            return  [
                'tanggal' => 'required',
                'nomor_pendaftaran_permohonan' => 'required',
                'nama_identitas_alamat_penerima' => 'required',
                'hasil_pekerjaan_yang_diterima' => 'required',
                'hasil_pekerjaan_yang_diterima.*' => 'required',
                'jenis_kegiatan_id' => 'required',
                'tanda_tangan_penerima' => 'required',
                'no_seri_sertipikat' => 'required',
                'no_seri_sertipikat.*' => 'required',
                'keterangan' => 'required',
            ];
        } else {
            return  [
                'tanggal' => 'required',
                'nomor_pendaftaran_permohonan' => 'required',
                'nama_identitas_alamat_penerima' => 'required',
                'hasil_pekerjaan_yang_diterima' => 'required',
                'hasil_pekerjaan_yang_diterima.*' => 'required',
                'jenis_kegiatan_id' => 'required',
                'tanda_tangan_penerima' => 'nullable',
                'no_seri_sertipikat' => 'required',
                'no_seri_sertipikat.*' => 'required',
                'keterangan' => 'required',
            ];
        }
    }
}
