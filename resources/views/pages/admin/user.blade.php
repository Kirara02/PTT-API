@extends('layouts.default_layout')
@section('title')
    {{ $title }}
@endsection
@push('css')
    <link href="{{ asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/icons/font-awesome/js/all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script>
        let url = '';
        let method = '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getUrl() {
            return url;
        }

        function getMethod() {
            return method;
        }
        var Table = $('#daTable').DataTable({
            ajax: "{{ route('admin.user.index') }}",
            processing: true,
            serverSide: true,
            responsive: true,
            columns: [{
                    data: 'DT_RowIndex'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'action'
                }
            ],
        });

        function create() {
            url = "{{ route('admin.user.store') }}";
            method = 'POST';
            $('.modal-header h5').html("Create User");
            $('#basicModal').modal('show');
        }

        function edit(id) {
            let editUrl = "{{ route('admin.user.edit', ':id') }}";
            editUrl = editUrl.replace(':id', id);
            url = "{{ route('admin.user.update', ':id') }}";
            url = url.replace(':id', id);
            method = "POST";
            $('.modal-body form').append('<input type="hidden" name="_method" value="PUT" />');
            $('.password').css('display', 'none');
            $('.password').find('input').prop('required', false);
            $.get(editUrl, function(res) {
                $('.modal-header h5').html("Edit User");
                $('input[name="name"]').val(res.data.name);
                $('input[name="email"]').val(res.data.email);
                $('#basicModal').modal('show');
            })
        }

        function resetPassword(id) {
            method = "PUT";
            $('#FormReset')[0].reset();
            $('.modal-header h5').html("Reset Password Akun");
            $('#resetModal').modal('show');
        }

        function destroy(id) {
            let deleteUrl = "{{ route('admin.user.destroy', ':id') }}";
            deleteUrl = deleteUrl.replace(':id', id);
            swal({
                title: 'Hapus data ini?',
                text: "Data ini tidak akan bisa dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#F44336',
                reverseButtons: true
            }).then((isConfirm) => {
                if (isConfirm.value) {
                    $.ajax({
                        url: deleteUrl,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            notification(response.status, response.message);
                            Table.ajax.reload(null, false);
                        },
                        error: function(res) {
                            notification(res.responseJSON.status, res.responseJSON.message);
                        }
                    })
                }
            })
        }

        function notification(status, message) {
            if (status == 'error') {
                toastr.error(message, status.toUpperCase(), {
                    closeButton: 1,
                    showDuration: "300",
                    hideDuration: "1000",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    timeOut: 5e3,
                    showEasing: "swing",
                    hideEasing: "linear"
                });
            } else {
                toastr.success(message, status.toUpperCase(), {
                    closeButton: 1,
                    showDuration: "300",
                    hideDuration: "1000",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                    timeOut: 5e3,
                    showEasing: "swing",
                    hideEasing: "linear"
                });
            }
        }

        function showPassword(that) {
            let type = $(that).closest('.input-group').find('input').attr('type');
            if (type == 'password') {
                $(that).closest('.input-group').find('input').attr('type', 'text');
                $(that).html('<i class="fa-regular fa-eye"></i>');
            } else {
                $(that).closest('.input-group').find('input').attr('type', 'password');
                $(that).html('<i class="fa-regular fa-eye-slash"></i>');
            }
        }
        $(document).ready(function() {
            $('#IdRole').selectpicker({
                liveSearch: true,
                header: "Pilih Role"
            });
            $('#basicModal').on('hide.bs.modal', function() {
                $('.modal-body form')[0].reset();
                $('#IdRole').selectpicker('val', '');
                $('#preview').attr('src', "{{ asset('dist/profiles/default.jpg') }}");
                $('.password').css('display', 'block');
                $('.password').find('input').prop('required', true);
                $('input[name="_method"]').remove();
            })
            $('#ProfilePhoto').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        console.log(event.target.result);
                        $('#preview').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
            $('#FormAccount').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData($(this)[0]);
                $.ajax({
                    url: getUrl(),
                    type: getMethod(),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(response) {
                        $('#basicModal').modal('hide');
                        notification(response.status, response.message);
                        Table.ajax.reload(null, false);
                    },
                    error: function(res) {
                        let fields = res.responseJSON.fields;
                        $.each(fields, function(i, val) {
                            $.each(val, function(idx, value) {
                                notification(response.responseJSON.status,
                                    value);
                            })
                        })
                    }
                })
            })
            $('#FormReset').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: getUrl(),
                    type: getMethod(),
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        $('#resetModal').modal('hide');
                        notification(response.status, response.message);
                        Table.ajax.reload(null, false);
                    },
                    error: function(res) {
                        let fields = res.responseJSON.fields;
                        $.each(fields, function(i, val) {
                            $.each(val, function(idx, value) {
                                notification(response.responseJSON.status,
                                    value);
                            })
                        })
                    }
                })
            })
        })
    </script>
@endpush
@section('content')
    <!--**********************************
                                    Content body start
                                ***********************************-->
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Accounts</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 m-b-30">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Account Table</h5>
                                    <button class="btn btn-primary float-right" onclick="create()"><i
                                            class="icon-plus mr-1"></i> Account</button>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="daTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NAME</th>
                                                    <th>EMAIL</th>
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->
    <!-- Modal -->
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormAccount" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <input type="text" id="Name" class="form-control" name="name" placeholder="Name"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" id="Email" class="form-control" name="email"
                                placeholder="account@email.com" required>
                        </div>
                        <div class="form-group password">
                            <label for="Password">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" id="Password" class="form-control" name="password"
                                    placeholder="******" required>
                                <div class="input-group-append">
                                    <button onclick="showPassword(this)" class="btn btn-outline-dark" type="button"><i
                                            class="fa-regular fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ProfilePhoto">Certificate User</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="certificate" id="ProfilePhoto">
                                    <label class="custom-file-label">Upload Certificate</label>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close <i
                            class="fa-solid fa-xmark"></i></button>
                    <button type="submit" class="btn btn-success text-white">Save <i
                            class="fa-solid fa-floppy-disk"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="resetModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FormReset" action="" method="post">
                        <div class="form-group password">
                            <label for="NewPassword">New Password</label>
                            <div class="input-group mb-3">
                                <input type="password" id="NewPassword" class="form-control" name="new_password"
                                    placeholder="******" required>
                                <div class="input-group-append">
                                    <button onclick="showPassword(this)" class="btn btn-outline-dark" type="button"><i
                                            class="fa-regular fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group password">
                            <label for="ConfirmPassword">Confirm Password</label>
                            <div class="input-group mb-3">
                                <input type="password" id="ConfirmPassword" class="form-control" name="confirm_password"
                                    placeholder="******" required>
                                <div class="input-group-append">
                                    <button onclick="showPassword(this)" class="btn btn-outline-dark" type="button"><i
                                            class="fa-regular fa-eye-slash"></i></button>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Tutup <i
                            class="fa-solid fa-xmark"></i></button>
                    <button type="submit" class="btn btn-success text-white">Simpan <i
                            class="fa-solid fa-floppy-disk"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
