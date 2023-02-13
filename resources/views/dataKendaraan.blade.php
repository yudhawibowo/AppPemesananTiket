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
                    <h1 class="m-0">Data Kendaraan</h1>
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
                                <th>Nama Tiket</th>
                                <th>Jenis</th>
                                <th>Nomor Kendaraan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade text-left" id="tambahKendaraan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah Kendaraan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <label class="m-0 mt-1">Nama</label>
                        <input placeholder="Nama" class="form-control" id="nama" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Jenis</label>
                        <input placeholder="Jenis" class="form-control" id="jenis" type="text"
                            autocomplete="off" required>
                        <label class="m-0 mt-1">Nomor Kendaraan</label>
                        <input placeholder="Nomor Kendaraan" class="form-control" id="nomor" type="text"
                            autocomplete="off" required>
                        <button type="button" id="btn-add-kendaraan" class="btn btn-primary mt-2">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="editKendaraan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Kendaraan</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <input type="hidden" id="idedit">
                        <label class="m-0 mt-1">Merek</label>
                        <input placeholder="Nama" class="form-control" id="namaedit" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Jenis</label>
                        <input placeholder="Jenis" class="form-control" id="jenisedit" type="text"
                            autocomplete="off" required>
                        <label class="m-0 mt-1">Nomor Kendaraan</label>
                        <input placeholder="Nomor Kendaraan" class="form-control" id="nomoredit" type="text"
                            autocomplete="off" required>
                        <button type="button" id="btn-edit-kendaraan" class="btn btn-primary mt-2">Update</button>
                    </form>
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
                    text: '<i class="fas fa-plus-circle"></i> Tambah Kendaraan',
                    "className": "generate-code",
                    action: function(e, dt, node, config) {
                        $('#tambahKendaraan').modal('toggle');
                    }
                }],
            });
        }

        function showModalEditKendaraan(id, nama, jenis, nomor) {
            $('#editKendaraan').modal('toggle');
            $("#idedit").val(id);
            $("#namaedit").val(nama);
            $("#jenisedit").val(jenis);
            $("#nomoredit").val(nomor);
        }

        $('#btn-add-kendaraan').click(function(e) {
            e.preventDefault();
            let nama = $('#nama').val().trim();
            let jenis = $('#jenis').val().trim();
            let nomor = $('#nomor').val().trim();
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (nama == "") {
                swal("error", "Nama Tidak Boleh Kosong", "error")
            } else if (jenis == "") {
                swal("error", "Jenis Tidak Boleh Kosong", "error")
            } else {
                swal({
                    title: "",
                    text: "Loading...",
                    icon: "{{ asset('img/icon/loading.gif') }}",
                    buttons: false,
                    closeOnClickOutside: false,
                });

                let myFormData = new FormData();
                myFormData.append('nama', nama);
                myFormData.append('jenis', jenis);
                myFormData.append('nomor', nomor);
                myFormData.append('_token', _token);
                $.ajax({
                    url: "{{ url('addkendaraan') }}",
                    type: "POST",
                    data: myFormData,
                    cache: false,
                    success: function(response) {
                        if (response.status == "error") {
                            swal("error", response.message, "error");
                        } else {
                            swal("", "Input Data Berhasil", "success").then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("", "Gagal Input Data", "error").then(function() {});
                    },
                    processData: false,
                    contentType: false,
                });
            }
        })

        $('#btn-edit-kendaraan').click(function(e) {
            e.preventDefault();
            let id = $('#idedit').val().trim();
            let nama = $('#namaedit').val().trim();
            let jenis = $('#jenisedit').val().trim();
            let nomor = $('#nomoredit').val().trim();
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (nama == "") {
                swal("error", "Nama Tidak Boleh Kosong", "error")
            } else if (jenis == "") {
                swal("error", "Jenis Tidak Boleh Kosong", "error")
            } else {
                swal({
                    title: "",
                    text: "Loading...",
                    icon: "{{ asset('img/icon/loading.gif') }}",
                    buttons: false,
                    closeOnClickOutside: false,
                });
                let myFormData = new FormData();
                myFormData.append('id', id);
                myFormData.append('nama', nama);
                myFormData.append('jenis', jenis);
                myFormData.append('nomor', nomor);
                myFormData.append('_token', _token);
                $.ajax({
                    url: "{{ url('editkendaraan') }}",
                    type: "POST",
                    data: myFormData,
                    cache: false,
                    success: function(response) {
                        if (response) {
                            swal("", "Edit Data Kendaraan Berhasil", "success").then(function() {
                                location.reload();
                            });
                        }
                    },
                    processData: false,
                    contentType: false,
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("", "Gagal Input Data", "error").then(function() {});
                    },
                });
            }
        })

        function deleteKendaraan(id) {
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
                            url: "{{ url('deletekendaraan') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: _token,
                            },
                            success: function(response) {
                                if (response) {
                                    swal("", "Hapus Kendaraan Berhasil", "success").then(function() {
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
                url: "/datakendaraan",
                type: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    swal.close();
                    for (let i = 0; i < data.length; i++) {
                        let idKendaraan = data[i].id;
                        let nama = data[i].nama;
                        let jenis = data[i].jenis;
                        let nomor = data[i].nomor
                        let btnAksi = "";

                        btnAksi =
                            `
                        <a title='edit' class='btn-aksi btn btn-sm btn-primary' onclick="showModalEditKendaraan('${idKendaraan}','${nama}', '${jenis}', '${nomor}')">Edit</a> 
                        <a title='delete' onclick="deleteKendaraan('${idKendaraan}')" class='btn-aksi btn btn-sm btn-danger'>Hapus</a>`;
                        arrayReturn.push([i + 1, nama, jenis, nomor, btnAksi]);
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
