@extends("layouts.master")

@push('style')
    <style>
    </style>
@endpush

@section('main')
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
        </div>
    </div>
    </div>

    <div class="container-fluid p-3">
        <div class="main-content">
            <section class="content">
                <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3 id="cTiket">0</h3>
                          <p>Tiket</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-ticket-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="height:30px"></a>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                        <div class="inner">
                          <h3 id="cKendaraan">0</h3>
                          <p>Kendaraan</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-bus"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="height:30px"></a>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3 id="cPemesanan">0</h3>
                          <p>Pemesanan</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer" style="height:30px"></a>
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>
                </div>
              </section>
        </div>
    </div>

@endsection

@push('script') 
<script type="text/javascript">
    generateData();

    function generateData() {
        var _token   = $('meta[name="csrf-token"]').attr('content');
        var arrayReturn = [];
        $.ajax({
            url: "/datadashboard",
            type:"POST",
            data:{
                _token: _token
            },
            success: function(data) {
                $("#cTiket").text(data['tiket']);
                $("#cKendaraan").text(data['kendaraan']);
                $("#cPemesanan").text(data['pemesanan']);
            }
        });
    } 
</script>
@endpush