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
                    <h1 class="m-0">Data Pemesanan</h1>
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
                                <th>Jenis Kendaraan</th>
                                <th>Harga Pemesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade text-left" id="modal-qris" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">QR Code</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="img-qris" src="img/qris/">
                </div>
            </div>
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
                        columns: [0, 1, 2, 3]
                    }
                }, ],
            });
        }

        function showQrCode(gambar) {
            $('#modal-qris').modal('toggle');

            if (gambar) {
                var src = `{{ asset('img/qris/${gambar}') }}`;
                $('#img-qris').attr("src", src);
            }
        }

        function deletePemesanan(id) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            swal({
                    title: "Apakah Anda Yakin?",
                    text: "Setelah Dihapus Tidak Bisa Dikembalikan Lagi",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal({
                            title: "",
                            text: "Loading...",
                            icon: "{{ asset('img/icon/loading.gif') }}",
                            buttons: false,
                            closeOnClickOutside: false,
                        });
                        $.ajax({
                            url: "{{ url('deletepemesanan') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: _token,
                            },
                            success: function(response) {
                                if (response) {
                                    swal("", "Hapus Pemesanan Berhasil", "success").then(function() {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("", "Gagal hapus data", "error").then(function() {});
                            },
                        });
                    }
                });
        }

        function ubahStatus(id) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            swal({
                    title: "Apakah Anda Yakin?",
                    text: "Konfirmasi Pembayaran User",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal({
                            title: "",
                            text: "Loading...",
                            icon: "{{ asset('img/icon/loading.gif') }}",
                            buttons: false,
                            closeOnClickOutside: false,
                        });
                        $.ajax({
                            url: "{{ url('konfirmasi-pemesanan') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: _token,
                            },
                            success: function(response) {
                                if (response) {
                                    swal("", "Berhasil Konfirmasi Pembayaran", "success").then(function() {
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                swal("", "Gagal", "error").then(function() {});
                            },
                        });
                    }
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
                url: "/datapemesanan",
                type: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    swal.close();
                    for (let i = 0; i < data.length; i++) {
                        let idPemesanan = data[i].id;
                        let nama = data[i].user.nama;
                        let jenis = data[i].tiket.jenis_kendaraan;
                        let harga = "Rp. " + data[i].tiket.harga
                        let statusBayar = "";
                        let bukti = data[i].bukti
                        let qr_code = data[i].qr_code
                        let btnAksi = "";
                        if (bukti == null) {
                            statusBayar = "Belum Dibayar"
                            btnAksi =
                                `
                        <a title='edit' class='btn-aksi btn btn-sm btn-primary' onclick="showQrCode('${qr_code}')">QR Code</a> 
                        <a title='delete' onclick="deletePemesanan('${idPemesanan}')" class='btn-aksi btn btn-sm btn-danger'>Hapus</a>`;
                        } else {
                            statusBayar =
                                `Sudah Dibayar <a target='_blank' href="{{ asset('img/user/${bukti}') }}" class='btn btn-sm btn-primary'>lihat bukti</a>`
                            btnAksi =
                                `
                        <a title='kofirmasi' onclick="ubahStatus('${idPemesanan}')" class='btn-aksi btn btn-sm btn-success'>Konfirmasi</a>
                        <a title='edit' class='btn-aksi btn btn-sm btn-primary' onclick="showQrCode('${qr_code}')">QR Code</a> 
                        <a title='delete' onclick="deletePemesanan('${idPemesanan}')" class='btn-aksi btn btn-sm btn-danger'>Hapus</a>`;
                        }


                        arrayReturn.push([i + 1, nama, jenis, harga, statusBayar, btnAksi]);
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
