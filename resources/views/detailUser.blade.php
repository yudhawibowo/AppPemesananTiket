@extends('layouts.master')

@push('style')
    <style>
        @media (max-width: 600px) {
            .card-body #photo {
                max-width: 300px;
            }
        }
    </style>
@endpush

@section('main')
    <div class="container-fluid p-3">
        <div class="main-content">
            <section class="section list-barang-section">
                <div class="card">
                    <div class="card-header" style="font-size:22px;font-weight:600">
                        Detail User
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <a id="wrap-photo" target="_blank"><img class="card-img-top" id="photo"
                                        caption="image-user"></a>
                            </div>
                            <div class="col-md-9">
                                <table class="table">
                                    <tr>
                                        <td>Nama User</td>
                                        <td><strong id="nama"></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><strong id="email"></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor HP</td>
                                        <td><strong id="nomor"></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
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
            var url = '{{ Request::url() }}';
            var id = url.substring(url.lastIndexOf('/') + 1)
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "/datadetailuser",
                type: "POST",
                data: {
                    _token: _token,
                    id: id
                },
                success: function(data) {
                    for (var i = 0, len = data.length; i < len; i++) {
                        var nama = data[i].nama
                        var email = data[i].email;
                        var nomor = data[i].nomor_hp
                        var gambar = data[i].photo;
                        $('#nama').text(nama);
                        $('#email').text(email);
                        $('#nomor').text(nomor);
                        if (gambar) {
                            var src = `{{ asset('img/user/${gambar}') }}`;
                            $('#photo').attr("src", src);
                            $('#wrap-photo').attr("href", src);
                        } else {
                            var src = `{{ asset('img/user/default.png') }}`;
                            $('#photo').attr("src", src);
                        }

                    }
                },
                error: function(request, status, error) {
                    swal("error", "Gagal Load", "error");
                }
            });
        }
    </script>
@endpush
