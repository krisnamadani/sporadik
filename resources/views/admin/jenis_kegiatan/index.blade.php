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
          <h1>Jenis Kegiatan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Jenis Kegiatan</li>
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
              <h3 class="card-title">Jenis Kegiatan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#add-modal">Tambah Jenis Kegiatan</button>
              <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped" width="100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Kegiatan</th>
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
  <div class="modal-dialog">
      <div class="modal-content">
        <form id="add-form">
            @csrf
            <div class="modal-header">
                <h4 class="modal-title">Tambah Jenis Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                      <label>Nama Kegiatan: <code>*</code></label>
                      <input type="text" class="form-control" name="nama_kegiatan" required placeholder="Masukkan nama kegiatan">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Tambah Jenis Kegiatan</button>
            </div>
        </form>
      </div>
  </div>
</div>

<div class="modal fade" id="edit-modal">
  <div class="modal-dialog">
      <div class="modal-content">
          <form id="edit-form">
              @csrf
              <div class="modal-header">
                  <h4 class="modal-title">Edit Jenis Kegiatan</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label>Nama Kegiatan: <code>*</code></label>
                        <input type="text" class="form-control" name="nama_kegiatan" required id="nama_kegiatan">
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-end">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success" id="edit-button">Simpan Jenis Kegiatan</button>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection

@section('foot')

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
      ajax: "{{ route('admin.jenis_kegiatan.data') }}",
      columns: [
          {
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              orderable: false,
              searchable: false
          },
          {data: 'nama_kegiatan', name: 'nama_kegiatan'},
          {
              data: 'action',
              name: 'action',
              orderable: false,
              searchable: false
          },
      ],
  });
});

$('#add-form').submit(function(event) {
    event.preventDefault();
    Swal.fire({
        text: "Simpan jenis kegiatan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
    }).then((result) => {
        if(result.isConfirmed) {
            var form_data = new FormData(this);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{ route('admin.jenis_kegiatan.store') }}",
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
        url: "{{ route('admin.jenis_kegiatan.edit') }}",
        dataType: 'json',
        data: {
            id: id,
        },
        success: function(response) {
            $('#id').val(response.id);
            $('#nama_kegiatan').val(response.nama_kegiatan);
            $('#edit-modal').modal('show');
        }
    });
}

$('#edit-form').submit(function(event) {
    event.preventDefault();
    Swal.fire({
        html: "Simpan jenis kegiatan?",
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
                url: "{{ route('admin.jenis_kegiatan.update') }}",
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
        text: "Hapus jenis kegiatan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type:"delete",
                url: "{{ route('admin.jenis_kegiatan.delete') }}",
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