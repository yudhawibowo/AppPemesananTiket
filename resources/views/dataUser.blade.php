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
                    <h1 class="m-0">Data User</h1>
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
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade text-left" id="tambahUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Tambah User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <label class="m-0 mt-1">Nama</label>
                        <input placeholder="Nama" class="form-control" id="nama" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Nomor HP</label>
                        <div class="input-group">
                            <span class="input-group-text">+62</span>
                            <input placeholder="Nomor HP" class="form-control" id="nomorhp" type="number"
                                autocomplete="off" required>
                        </div>
                        <label class="m-0 mt-1">Email</label>
                        <input placeholder="Email" class="form-control" id="email" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Password</label>
                        <input placeholder="Password" class="form-control" id="password" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Photo</label>
                        <input type="file" class="form-control" id="photo" accept="image/*capture=filesystem">
                        <button type="button" id="btn-add-user" class="btn btn-primary mt-2">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit User</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <input type="hidden" id="idedit">
                        <label class="m-0 mt-1">Nama</label>
                        <input placeholder="Nama" class="form-control" id="namaedit" type="text" autocomplete="off">
                        <label class="m-0 mt-1">Nomor</label>
                        <input placeholder="Nomor HP" class="form-control" id="nomoredit" type="number"
                            autocomplete="off" required>
                        <label class="m-0 mt-1">Photo</label>
                        <input type="file" class="form-control" id="photoedit" accept="image/*capture=filesystem">
                        <button type="button" id="btn-edit-user" class="btn btn-primary mt-2">Update</button>
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
                    text: '<i class="fas fa-plus-circle"></i> Tambah User',
                    "className": "generate-code",
                    action: function(e, dt, node, config) {
                        $('#tambahUser').modal('toggle');
                    }
                }],
            });
        }

        function showModalEditUser(id, nama, nomor) {
            $('#editUser').modal('toggle');
            $("#idedit").val(id);
            $("#namaedit").val(nama);
            $("#nomoredit").val(nomor);
            if (aktif) {
                $('#aktifedit').prop('checked', true);
            } else {
                $('#aktifedit').prop('checked', false);
            }
        }

        $('#btn-add-user').click(function(e) {
            e.preventDefault();
            let nama = $('#nama').val().trim();
            let nomor = $('#nomorhp').val().trim();
            let email = $('#email').val().trim();
            let password = $('#password').val().trim();
            let photo = $("#photo");
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (nama == "") {
                swal("error", "Nama Tidak Boleh Kosong", "error")
            } else if (nomor == "") {
                swal("error", "Nomor Tidak Boleh Kosong", "error")
            } else if (email == "") {
                swal("error", "Email Tidak Boleh Kosong", "error")
            } else if (password == "") {
                swal("error", "Password Tidak Boleh Kosong", "error")
            } else if (password.length < 5) {
                swal("error", "Password Minimal 5 Karakter", "error")
            } else {
                swal({
                    title: "",
                    text: "Loading...",
                    icon: "{{ asset('img/icon/loading.gif') }}",
                    buttons: false,
                    closeOnClickOutside: false,
                });

                if (nomor.substring(0, 1) == "8") {
                    nomor = "0" + nomor;
                }

                let myFormData = new FormData();
                myFormData.append('nama', nama);
                myFormData.append('nomor', nomor);
                myFormData.append('email', email);
                myFormData.append('password', password);
                myFormData.append('gambar', photo.prop("files")[0]);
                myFormData.append('_token', _token);
                $.ajax({
                    url: "{{ url('adduser') }}",
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

        $('#btn-edit-user').click(function(e) {
            e.preventDefault();
            let id = $('#idedit').val().trim();
            let nama = $('#namaedit').val().trim();
            let nomor = $('#nomoredit').val().trim();
            let photo = $("#photoedit");
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (nama == "") {
                swal("error", "Nama Tidak Boleh Kosong", "error")
            } else {
                swal({
                    title: "",
                    text: "Loading...",
                    icon: "{{ asset('img/icon/loading.gif') }}",
                    buttons: false,
                    closeOnClickOutside: false,
                });
                let myFormDataEdit = new FormData();
                myFormDataEdit.append('id', id);
                myFormDataEdit.append('nama', nama);
                myFormDataEdit.append('nomor', nomor);
                myFormDataEdit.append('gambar', photo.prop("files")[0]);
                myFormDataEdit.append('_token', _token);
                $.ajax({
                    url: "{{ url('edituser') }}",
                    type: "POST",
                    data: myFormDataEdit,
                    cache: false,
                    success: function(response) {
                        if (response) {
                            swal("", "Edit Data User Berhasil", "success").then(function() {
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

        function deleteUser(id) {
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
                            url: "{{ url('deleteuser') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: _token,
                            },
                            success: function(response) {
                                if (response) {
                                    swal("", "Hapus User Berhasil", "success").then(function() {
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
                url: "/datauser",
                type: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    swal.close();
                    for (let i = 0, len = data.length; i < len; i++) {
                        let idUser = data[i].id;
                        let nama = data[i].nama;
                        let nomor = data[i].nomor_hp
                        let email = data[i].email
                        let namaC = `<a href='/detailuser/${idUser}'>${nama}</a>`;
                        let btnAksi = "";

                        @if (auth()->user()->role_id == 1)
                            btnAksi =
                                `<a title='detail' href='/detailuser/${idUser}' class='btn-aksi btn btn-sm btn-secondary'>Detail</a> 
                        <a title='edit' class='btn-aksi btn btn-sm btn-primary' onclick="showModalEditUser('${idUser}','${nama}', '${nomor}')">Edit</a> 
                        <a title='delete' onclick="deleteUser('${idUser}')" class='btn-aksi btn btn-sm btn-danger'>Hapus</a>`;
                        @else
                            btnAksi =
                                `<a title='detail' href='/detailuser/${idUser}' class='btn-aksi btn btn-sm btn-secondary'>Detail</a>`;
                        @endif
                        arrayReturn.push([i + 1, namaC, nomor, email, btnAksi]);
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
