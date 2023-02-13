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
                    <h1 class="m-0">Tiket Masuk</h1>
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
                                <th>kode</th>
                                <th>Nama Tiket</th>
                                <th>Harga Tiket</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade text-left" id="editTiket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div style="max-width:600px;" class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div style="overflow-y: auto;" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Tiket Masuk</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="">
                        <input type="hidden" id="idedit">
                        <label class="m-0 mt-1">Kode</label>
                        <input placeholder="Kode" class="form-control" id="kodeedit" type="text" autocomplete="off"
                            required>
                        <label class="m-0 mt-1">Nama</label>
                        <input placeholder="Nama Tiket" class="form-control" id="jenisedit" type="text"
                            autocomplete="off" required>
                        <label class="m-0 mt-1">Harga Tiket</label>
                        <input placeholder="Harga Tiket" class="form-control" id="hargaedit" type="text"
                            autocomplete="off" required>
                        <button type="button" id="btn-edit-tiket" class="btn btn-primary mt-2">Update</button>
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
                buttons: [ ],
            });
        }

        function showModalEditTiket(id, kode, jenis, harga) {
            $('#editTiket').modal('toggle');
            $("#idedit").val(id);
            $("#kodeedit").val(kode);
            $("#jenisedit").val(jenis);
            $("#hargaedit").val(harga);
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
                url: "/datatiketmasuk",
                type: "POST",
                data: {
                    _token: _token
                },
                success: function(data) {
                    swal.close();
                    for (let i = 0; i < data.length; i++) {
                        let idTiket = data[i].id;
                        let kode = data[i].kode;
                        let jenis = data[i].jenis;
                        let harga = data[i].harga
                        let btnAksi = "";

                        btnAksi =
                            `
                        <a title='edit' class='btn-aksi btn btn-sm btn-primary' onclick="showModalEditTiket('${idTiket}','${kode}', '${jenis}', '${harga}')">Edit</a>`;
                        arrayReturn.push([kode, jenis, harga, btnAksi]);
                    }
                    inittable(arrayReturn);
                },
                error: function(request, status, error) {
                    swal("error", "Gagal Load", "error");
                }
            });
        }

        $('#btn-edit-tiket').click(function(e) {
            e.preventDefault();
            let id = $('#idedit').val().trim();
            let kode = $('#kodeedit').val().trim();
            let jenis = $('#jenisedit').val().trim();
            let harga = $('#hargaedit').val().trim();
            let _token = $('meta[name="csrf-token"]').attr('content');
            if (kode == "") {
                swal("error", "Kode Tidak Boleh Kosong", "error")
            } else if (jenis == "") {
                swal("error", "Jenis Tiket Tidak Boleh Kosong", "error")
            } else if (harga == "") {
                swal("error", "Harga Tiket Tidak Boleh Kosong", "error")
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
                myFormData.append('kode', kode);
                myFormData.append('jenis', jenis);
                myFormData.append('harga', harga);
                myFormData.append('_token', _token);
                $.ajax({
                    url: "{{ url('edittiket') }}",
                    type: "POST",
                    data: myFormData,
                    cache: false,
                    success: function(response) {
                        if (response) {
                            swal("", "Edit Data Tiket Berhasil", "success").then(function() {
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
