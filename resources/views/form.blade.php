@extends('layouts.guest')

@section('head')

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

@endsection

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tambah Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('form') }}">Guest</a></li>
            <li class="breadcrumb-item active">Tambah Data</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tambah Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
							<form id="add-form">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Tanggal: <code>*</code></label>
												<div class="input-group date" id="tanggal" data-target-input="nearest">
														<input type="text" class="form-control datetimepicker-input" data-target="#tanggal" name="tanggal">
														<div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
																<div class="input-group-text"><i class="fa fa-calendar"></i></div>
														</div>
												</div>
										</div>
										<div class="form-group">
												<label>Nomor Pendaftaran Permohonan: <code>*</code></label>
												<input type="text" class="form-control" name="nomor_pendaftaran_permohonan" required placeholder="Masukkan nomor pendaftaran permohonan">
										</div>
										<div class="form-group">
												<label>Nama, Identitas Alamat Penerima: <code>*</code></label>
												<input type="text" class="form-control" name="nama_identitas_alamat_penerima" required placeholder="Masukkan nama, identitas alamat penerima">
										</div>
										<div id="add-hasil-wrapper">
											<div class="form-group">
												<label>Hasil Pekerjaan Yang Diterima: <code>*</code></label>
												<button type="button" class="btn btn-success btn-xs" id="add-hasil-button">&nbsp;<i class="nav-icon fas fa-plus"></i>&nbsp;</button>
												<input type="text" class="form-control" name="hasil_pekerjaan_yang_diterima[]" required placeholder="Masukkan hasil pekerjaan yang diterima" id="add-hasil-pekerjaan">
											</div>
										</div>
										<button type="submit" class="btn btn-success">Tambah Data</button>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Jenis Kegiatan <code>*</code></label>
											<select class="form-control" name="jenis_kegiatan_id" required>
												<option selected disabled>Pilih jenis kegiatan</option>
												@foreach ($jenis_kegiatan as $item)
													<option value="{{ $item->id }}">{{ $item->nama_kegiatan }}</option>
												@endforeach
											</select>
										</div>
										
										<div class="form-group">
												<label>Tanda Tangan Penerima: <code>*</code></label>
												<div class="custom-file">
													<input type="file" class="custom-file-input" name="tanda_tangan_penerima">
													<label class="custom-file-label">Pilih file</label>
											</div>
										</div>
										<div class="form-group">
											<label>Keterangan: <code>*</code></label>
											<input type="text" class="form-control" name="keterangan" required placeholder="Masukkan keterangan">
										</div>
										<div id="add-sertipikat-wrapper">
											<div class="form-group">
												<label>No. Seri Sertipikat: <code>*</code></label>
												<button type="button" class="btn btn-success btn-xs" id="add-sertipikat-button">&nbsp;<i class="nav-icon fas fa-plus"></i>&nbsp;</button>
												<button type="button" class="btn btn-success btn-xs" onclick="goRandom()">&nbsp;<i class="nav-icon fas fa-sync"></i>&nbsp;</button>
												<input type="text" class="form-control" name="no_seri_sertipikat[]" required placeholder="Masukkan no. seri sertipikat" id="add-no-seri-sertipikat">
											</div>
										</div>
									</div>
								</div>
							</form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('foot')

<!-- InputMask -->
<script src="{{ asset('admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

{{-- SweetAlert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page specific script -->
<script>
$(function () {
  //Date picker
  $('#tanggal').datetimepicker({
      format: 'DD/MM/YYYY',
      defaultDate: moment("{{ date('d/m/Y') }}", "DD/MM/YYYY"),
  });

  bsCustomFileInput.init();
});

function makeletter(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function makenumber(length) {
    var result           = '';
    var characters       = '0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

function incrementString(str) {
  var count = str.match(/\d*$/);
  return str.substr(0, count.index) + (++count[0]);
};

function goRandom() {
  $('#add-no-seri-sertipikat').val(makeletter(2) + makenumber(7));
}

function goRandom2() {
  $('#edit-no-seri-sertipikat').val(makeletter(2) + makenumber(7));
}

$(document).ready(function() {
  let x = 1;

  $('#add-hasil-button').click(function() {
    let last = $('#add-hasil-wrapper .form-group:last-child').children('.form-control').val();
    let hasil = "";

    if(last != "") {
      let pisahHasil = last.split(".");
      let pisahHasil2 = pisahHasil[1].split("/");
      hasil = pisahHasil[0] + '.' + ++pisahHasil2[0] + '/' + pisahHasil2[1];
    }

    let addHasilHTML = '<div class="form-group"><label>Hasil Pekerjaan Yang Diterima ' + ++x + ': <code>*</code></label> <button type="button" class="btn btn-danger btn-xs" id="remove-hasil-button">&nbsp;<i class="nav-icon fas fa-minus"></i>&nbsp;</button><input type="text" class="form-control" name="hasil_pekerjaan_yang_diterima[]" required placeholder="Masukkan hasil pekerjaan yang diterima" value="' + hasil + '"></div>';
    
    $('#add-hasil-wrapper').append(addHasilHTML);
  });

  $('#add-hasil-wrapper').on('click', '#remove-hasil-button', function(e){
    $(this).parent('div').remove();
    x--;
  });


  let y = 1;

  $('#add-sertipikat-button').click(function() {
    let last = $('#add-sertipikat-wrapper .form-group:last-child').children('.form-control').val();
    let hasil = "";

    if(last != "") {
      hasil = incrementString(last);
    }

    let addSertipikatHTML = '<div class="form-group"><label>No. Seri Sertipikat ' + ++y + ': <code>*</code></label> <button type="button" class="btn btn-danger btn-xs" id="remove-hasil-button">&nbsp;<i class="nav-icon fas fa-minus"></i>&nbsp;</button><input type="text" class="form-control" name="no_seri_sertipikat[]" required placeholder="Masukkan no. seri sertipikat" value="' + hasil + '"></div>';
    
    $('#add-sertipikat-wrapper').append(addSertipikatHTML);
  });

  $('#add-sertipikat-wrapper').on('click', '#remove-hasil-button', function(e){
      $(this).parent('div').remove();
      y--;
  });

  // edit

  $('#edit-hasil-wrapper').on('click', '#remove-seri-button', function(e){
      $(this).parent('div').remove();
  });
  $('#edit-sertipikat-wrapper').on('click', '#remove-seri-button', function(e){
      $(this).parent('div').remove();
  });

});

$('#add-form').submit(function(event) {
    event.preventDefault();
    Swal.fire({
        text: "Simpan data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
    }).then((result) => {
        if(result.isConfirmed) {
            var form_data = new FormData(this);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('form.store') }}",
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                data: form_data,
                error: function(response) {
                    error = JSON.parse(response.responseText);
                    Swal.fire({text: error.message, icon: "error", });
                },
                success: function(response) {
                    if(response.status == true) {
                        Swal.fire({text: response.message, icon: "success"});
                    } else if(response.status == false) {
                        Swal.fire({text: response.message, icon: "error", });
                    } else {
                        Swal.fire({text: "Unexpected error", icon: "error", });
                    }
                }
            });
        }
    })
});
</script>
@endsection