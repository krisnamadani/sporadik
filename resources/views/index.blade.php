<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="colorlib.com">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet" />
    <link href="{{ asset('search/css/main.css') }}" rel="stylesheet" />
    
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="shortcut icon" href="{{ asset('sporadik/img/icon-16.webp') }}" type="image/x-icon">
    <link rel="favicon" href="{{ asset('sporadik/img/icon-16.webp') }}" type="image/x-icon">
  </head>
  <body>
    <div class="s013">
      <form method="get">
        <fieldset>
          <legend><a href="{{ route('login') }}"><img src="{{ asset('sporadik/img/icon-150.webp') }}" width="150" height="150"></a></legend>
          <legend>SPORADIK</legend>
        </fieldset>
        <div class="inner-form">
          <div class="left">
            <div class="input-wrap first">
              <div class="input-field first">
                <label>Kata Kunci</label>
                <input type="text" placeholder="Masukkan kata kunci" name="keyword" value="{{ app('request')->input('keyword') }}">
              </div>
            </div>
            <div class="input-wrap second">
              <div class="input-field second">
                <label>Cari Berdasarkan</label>
                <div class="input-select">
                  <select data-trigger="" name="category">
                    <option selected disabled value="" placeholder="">Pilih Kategori</option>
                    <option value="1" {{ app('request')->input('category') == 1 ? 'selected' : '' }}>Nomor Pendaftaran</option>
                    <option value="2" {{ app('request')->input('category') == 2 ? 'selected' : '' }}>Identitas Penerima</option>
                    <option value="3" {{ app('request')->input('category') == 3 ? 'selected' : '' }}>No. Seri Sertipikat</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button class="btn-search" type="submit">CARI</button>
        </div>
        @if (isset($results))
          <h4 class="text-light mt-4 mb-2">Hasil Pencarian</h4>
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table mb-0" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">No. Pendaftaran</th>
                      <th scope="col">Identitas Penerima</th>
                      <th scope="col">Hasil</th>
                      <th scope="col">Kegiatan</th>
                      <th scope="col">No. Seri Sertipikat</th>
                      <th scope="col">Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($results as $data)
                      <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $data->tanggal }}</td>
                        <td>{{ $data->nomor_pendaftaran_permohonan }}</td>
                        <td>{{ $data->nama_identitas_alamat_penerima }}</td>
                        <td>{{ $data->hasil_pekerjaan_yang_diterima }}</td>
                        <td>{{ $data->jenis_kegiatan }}</td>
                        <td>{{ $data->no_seri_sertipikat }}</td>
                        <td>{{ $data->keterangan }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @endif
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="{{ asset('search/js/extention/choices.js') }}"></script>
    <script>
      const choices = new Choices('[data-trigger]',
      {
        searchEnabled: false,
        itemSelectText: '',
      });

    </script>
  </body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
