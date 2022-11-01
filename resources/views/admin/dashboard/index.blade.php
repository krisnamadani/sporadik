@extends('layouts.admin')

@section('head')

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    
@endsection

@section('body')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      @if($belum_verifikasi > 0)
        <div class="alert alert-danger" role="alert">
          Anda memiliki <strong id="count">{{ $belum_verifikasi }}</strong> data yang belum diverifikasi
        </div>
      @endif

      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h5 class="m-0">Home</h5>
            </div>
            <div class="card-body">
              <p class="card-text">Selamat datang <b>{{ Auth::user()->name }}</b> di halaman admin</p>
            </div>
          </div>
        </div>
        <!-- /.col-md-6 -->

        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Yang Belum Diverifikasi</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped" width="100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Pendaftaran</th>
                    <th>Identitas Penerima</th>
                    <th>Jenis Kegiatan</th>
                    <th>Keterangan</th>
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
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="detail-modal">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Detail Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Tanggal: <code>*</code></label>
                  <input type="text" class="form-control" required id="detail_tanggal" readonly>
                </div>
                <div class="form-group">
                  <label>Nomor Pendaftaran Permohonan: <code>*</code></label>
                  <input type="text" class="form-control" required id="detail_nomor_pendaftaran_permohonan" readonly>
                </div>
                <div class="form-group">
                  <label>Nama, Identitas Alamat Penerima: <code>*</code></label>
                  <input type="text" class="form-control" required id="detail_nama_identitas_alamat_penerima" readonly>
                </div>
                <div class="form-group">
                  <label>Jenis Kegiatan <code>*</code></label>
                  <input type="text" class="form-control" required id="detail_jenis_kegiatan" readonly>
                </div>
                <div id="detail-hasil-wrapper">
                </div>
              </div>
              <div class="col-sm-12 col-md-6">
                <div class="form-group">
                  <label>Tanda Tangan Penerima:</label>
                  <img src="" class="ttd" id="detail_tanda_tangan_penerima">
                </div>
                <div class="form-group">
                  <label>Keterangan: <code>*</code></label>
                  <input type="text" class="form-control" required id="detail_keterangan" readonly>
                </div>
                <div id="detail-sertipikat-wrapper">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
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
      ajax: "{{ route('admin.dashboard.data') }}",
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
          {data: 'jenis_kegiatan_id', name: 'jenis_kegiatan_id'},
          {data: 'keterangan', name: 'keterangan'},
          {
              data: 'action',
              name: 'action',
              orderable: false,
              searchable: false
          },
      ],
  });
});

function verification(id) {
    Swal.fire({
        text: "Verifikasi data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
    }).then((result) => {
        if(result.isConfirmed) {
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type:"post",
                url: "{{ route('admin.dashboard.verification') }}",
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
                        let count = $('#count').text();
                        count--;
                        $('#count').text(count);
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

function detail(id) {
    $.ajax({
        type:"get",
        url: "{{ route('admin.dashboard.detail') }}",
        dataType: 'json',
        data: {
            id: id,
        },
        success: function(response) {
            $('#detail_tanggal').val(response.tanggal);
            $('#detail_nomor_pendaftaran_permohonan').val(response.nomor_pendaftaran_permohonan);
            $('#detail_nama_identitas_alamat_penerima').val(response.nama_identitas_alamat_penerima);
            $('#detail_jenis_kegiatan').val(response.jenis_kegiatan.nama_kegiatan);
            $('#detail_tanda_tangan_penerima').attr("src", response.tanda_tangan_penerima);
            $('#detail_keterangan').val(response.keterangan);
            
            $('#detail-hasil-wrapper').empty();
            let n = 1;
            response.hasil_pekerjaan.forEach(function (item, index) {
              $('#detail-hasil-wrapper').append('<div class="form-group"><label>Hasil Pekerjaan Yang Diterima ' + n++ + ':</label><input type="text" class="form-control" value="' + item.hasil_pekerjaan_yang_diterima + '" readonly></div>');
            });

            $('#detail-sertipikat-wrapper').empty();
            let m = 1;
            response.sertipikat.forEach(function (item, index) {
              $('#detail-sertipikat-wrapper').append('<div class="form-group"><label>No. Seri Sertipikat ' + m++ + ':</label><input type="text" class="form-control" value="' + item.no_seri_sertipikat + '" readonly></div>');
            });

            $('#detail-modal').modal('show');
        }
    });
}
</script>
@endsection