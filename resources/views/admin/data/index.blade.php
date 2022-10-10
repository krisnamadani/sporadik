@extends('layouts.admin')

@section('head')

<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    
@endsection

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Data</li>
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
              <h3 class="card-title">Data</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#add-modal">Tambah Data</button>
              <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped" width="100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Pendaftaran</th>
                    <th>Identitas Penerima</th>
                    <th>Hasil Pekerjaan</th>
                    <th>No Seri Sertipikat</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
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

<div class="modal fade" id="add-modal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="add-form">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                  <div class="form-group">
                      <label>Hasil Pekerjaan Yang Diterima: <code>*</code></label>
                      <input type="text" class="form-control" name="hasil_pekerjaan_yang_diterima" required placeholder="Masukkan hasil pekerjaan yang diterima">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jenis Kegiatan: <code>*</code></label>
                    <input type="text" class="form-control" name="jenis_kegiatan" required placeholder="Masukkan jenis kegiatan">
                  </div>
                  <div class="form-group">
                      <label>Tanda Tangan Penerima: <code>*</code></label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="tanda_tangan_penerima">
                        <label class="custom-file-label">Pilih file</label>
                    </div>
                  </div>
                  <div class="form-group">
                      <label>No. Seri Sertipikat: <code>*</code></label>
                      <input type="text" class="form-control" name="no_seri_sertipikat" required placeholder="Masukkan no. seri sertipikat">
                  </div>
                  <div class="form-group">
                    <label>Keterangan: <code>*</code></label>
                    <input type="text" class="form-control" name="keterangan" required placeholder="Masukkan keterangan">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Data</button>
            </div>
        </form>
      </div>
  </div>
</div>

<div class="modal fade" id="edit-modal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <form id="edit-form">
              @csrf
              <div class="modal-header">
                  <h4 class="modal-title">Edit User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12 col-md-6">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                      <label>Tanggal:</label>
                        <div class="input-group date" id="tanggal2" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#tanggal2" name="tanggal">
                            <div class="input-group-append" data-target="#tanggal2" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nomor Pendaftaran Permohonan: <code>*</code></label>
                        <input type="text" class="form-control" name="nomor_pendaftaran_permohonan" required id="nomor_pendaftaran_permohonan">
                    </div>
                    <div class="form-group">
                        <label>Nama, Identitas Alamat Penerima: <code>*</code></label>
                        <input type="text" class="form-control" name="nama_identitas_alamat_penerima" required id="nama_identitas_alamat_penerima">
                    </div>
                    <div class="form-group">
                        <label>Hasil Pekerjaan Yang Diterima: <code>*</code></label>
                        <input type="text" class="form-control" name="hasil_pekerjaan_yang_diterima" required id="hasil_pekerjaan_yang_diterima">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                      <label>Jenis Kegiatan: <code>*</code></label>
                      <input type="text" class="form-control" name="jenis_kegiatan" required id="jenis_kegiatan">
                    </div>
                    <div class="form-group">
                        <label>Tanda Tangan Penerima:</label>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="tanda_tangan_penerima">
                          <label class="custom-file-label">Pilih file</label>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>No. Seri Sertipikat: <code>*</code></label>
                        <input type="text" class="form-control" name="no_seri_sertipikat" required id="no_seri_sertipikat">
                    </div>
                    <div class="form-group">
                      <label>Keterangan: <code>*</code></label>
                      <input type="text" class="form-control" name="keterangan" required id="keterangan">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-end">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success" id="edit-button">Simpan Data</button>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection

@section('foot')

<!-- InputMask -->
<script src="{{ asset('admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- bs-custom-file-input -->
<script src="{{ asset('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

{{-- SweetAlert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page specific script -->
<script>
$(function () {
  var table = $('#datatable').DataTable({
      processing: false,
      serverSide: true,
      responsive: true,
      ajax: "{{ route('admin.data.data') }}",
      columns: [
          {
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false
          },
          {data: 'tanggal', name: 'tanggal'},
          {data: 'nomor_pendaftaran_permohonan', name: 'nomor_pendaftaran_permohonan'},
          {data: 'nama_identitas_alamat_penerima', name: 'nama_identitas_alamat_penerima'},
          {data: 'hasil_pekerjaan_yang_diterima', name: 'hasil_pekerjaan_yang_diterima'},
          {data: 'no_seri_sertipikat', name: 'no_seri_sertipikat'},
          {
              data: 'action',
              name: 'action',
              orderable: false,
              searchable: false
          },
      ],
  });

  //Date picker
  $('#tanggal').datetimepicker({
      format: 'DD/MM/YYYY',
      defaultDate: moment("{{ date('d/m/Y') }}", "DD/MM/YYYY"),
  });

  bsCustomFileInput.init();
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
                url: "{{ route('admin.data.store') }}",
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
                        setTimeout(function() { $('#datatable').DataTable().ajax.reload(null, false); }, 500);
                        $('#add-modal').modal('hide');
                        $('#add-form').trigger("reset");
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

function edit(id) {
    $.ajax({
        type:"get",
        url: "{{ route('admin.data.edit') }}",
        dataType: 'json',
        data: {
            id: id,
        },
        success: function(response) {
            $('#id').val(response.id);
            $('#tanggal2').datetimepicker({
                format: 'DD/MM/YYYY',
                defaultDate: moment(response.tanggal, "DD/MM/YYYY"),
            });
            $('#nomor_pendaftaran_permohonan').val(response.nomor_pendaftaran_permohonan);
            $('#nama_identitas_alamat_penerima').val(response.nama_identitas_alamat_penerima);
            $('#hasil_pekerjaan_yang_diterima').val(response.hasil_pekerjaan_yang_diterima);
            $('#jenis_kegiatan').val(response.jenis_kegiatan);
            $('#no_seri_sertipikat').val(response.no_seri_sertipikat);
            $('#keterangan').val(response.keterangan);
            $('#edit-modal').modal('show');
        }
    });
}

$('#edit-form').submit(function(event) {
    event.preventDefault();
    Swal.fire({
        html: "Simpan data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if(result.isConfirmed) {
            var form_data = new FormData(this);
            form_data.append("_method", "PUT");
            $.ajax({
                type: "post",
                enctype: 'multipart/form-data',
                url: "{{ route('admin.data.update') }}",
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
                        setTimeout(function() { $('#datatable').DataTable().ajax.reload(null, false); }, 500);
                        $('#edit-modal').modal('hide');
                        $('#edit-form').trigger("reset");
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

function remove(id) {
    Swal.fire({
        text: "Hapus data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type:"delete",
                url: "{{ route('admin.data.delete') }}",
                dataType: 'json',
                data: {
                    id: id,
                },
                error: function(response) {
                    error = JSON.parse(response.responseText);
                    Swal.fire({text: error.message, icon: "error", });
                },
                success: function(response) {
                    if(response.status == true) {
                        Swal.fire({text: response.message, icon: "success"});
                        setTimeout(function() { $('#datatable').DataTable().ajax.reload(null, false); }, 500);
                    } else if(response.status == false) {
                        Swal.fire({text: response.message, icon: "error", });
                    } else {
                        Swal.fire({text: "Unexpected error", icon: "error", });
                    }
                }
            });
        }
    })
}
</script>
@endsection