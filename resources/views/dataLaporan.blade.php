@extends('layouts.master')

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
                    <h1 class="m-0">Pemesanan Yang Telah Selesai</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-3">
        <div class="main-content">
            <section class="section mt-1 list-barang-section">
                <div class="tabel-barang">
                    <table id="listing-data" class="table table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama User</th>
                                <th>Jumlah Tiket</th>
                                <th>Total Pemesanan</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Tanggal Konfirmasi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript">
        generateData();

        function inittable(data) {
            $('#listing-data').DataTable({
                "responsive": true,
                "aaData": data,
                "dom": 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<span class="green"><img src="https://img.icons8.com/color/48/000000/ms-excel.png"/>Export</span>',
                    title: 'Data Pemesanan ' + getDateToday(),
                    download: 'open',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }, ],
            });
        }

        function generateData() {
            let _token = $('meta[name="csrf-token"]').attr('content');
            let arrayReturn = [];
            swal({
                title: "",
                text: "Loading...",
                icon: "{{ asset('img/icon/loading.gif') }}",
                buttons: false,
                closeOnClickOutside: false,
            });
            $.ajax({
                url: "/datalaporan",
                type: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    swal.close();
                    for (let i = 0; i < data.length; i++) {
                        let idPemesanan = data[i].id;
                        let nama = data[i].user.nama;
                        let total_qty = data[i].total_qty;
                        let total_harga = "Rp. " + data[i].total_harga;
                        let statusBayar = "";
                        let tanggal_pemesanan = data[i].tanggal_pemesanan;
                        let tanggal_konfirmasi = data[i].tanggal_konfirmasi;

                        arrayReturn.push([i + 1, nama, total_qty, total_harga, tanggal_pemesanan, tanggal_konfirmasi]);
                    }
                    inittable(arrayReturn);
                },
                error: function(request, status, error) {
                    swal("error", "Gagal Load", "error");
                }
            });
        }

        function getDateToday() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = dd + '-' + mm + '-' + yyyy;
            return today;
        }
    </script>
@endpush
