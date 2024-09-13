<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/icon/icofont/css/icofont.css') }}">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body themebg-pattern="theme1">
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

      <section class="login-block">
          <!-- Container-fluid starts -->
          <div class="container">
              <div class="row">
                  <div class="col-sm-12">
                      <!-- Authentication card start -->

                          <form class="md-float-material form-material">
                              <div class="text-center">
                                  <img src="{{ asset('dist/images/logo-uniguard.svg') }}" width="224" alt="logo.png">
                              </div>
                              @csrf
                              <div class="auth-box card">
                                  <div class="card-block">
                                      <div class="row m-b-20">
                                          <div class="col-md-12">
                                              <h3 class="text-center">Sign In</h3>
                                          </div>
                                      </div>
                                      <div class="alert-wrapper"></div>
                                      <div class="form-group form-primary">
                                          <input type="text" name="email" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Your Email Address</label>
                                      </div>
                                      <div class="form-group form-primary">
                                          <input type="password" name="password" class="form-control">
                                          <span class="form-bar"></span>
                                          <label class="float-label">Password</label>
                                      </div>
                                      <div class="row m-t-25 text-left">
                                          <div class="col-12">
                                              <div class="checkbox-fade fade-in-primary d-">
                                                  <label>
                                                      <input type="checkbox" name="remember" value="">
                                                      <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                      <span class="text-inverse">Remember me</span>
                                                  </label>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row m-t-30">
                                          <div class="col-md-12">
                                              <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <!-- end of form -->
                  </div>
                  <!-- end of col-sm-12 -->
              </div>
              <!-- end of row -->
          </div>
          <!-- end of container-fluid -->
      </section>

    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery/jquery.min.js ') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui/jquery-ui.min.js ') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js ') }}"></script>
    <!-- waves js -->
    <script src="{{ asset('assets/pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/common-pages.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function alertShow(message, status) {
            let wrapper = $('.alert-wrapper');
            wrapper.append('<div class="alert alert-' + status + ' alert-dismissible fade show">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>' +
                '</button> ' + message +
                '</div>');
        }
        $(document).ready(function() {
            $('.form-material').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData($(this)[0]);
                formData.append('remember_me', $('input[name="remember"]').prop('checked')?true:false);
                $.ajax({
                    url: "{{ route('auth.login') }}",
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: "JSON",
                    success: function(response) {
                        $('.alert-wrapper').empty();
                        alertShow(response.message, response.status);
                        window.location.href = "{{ route('auth.dashboard') }}";
                    },
                    error: function(response) {
                        let res = response.responseJSON;
                        $('.alert-wrapper').empty();
                        if (response.status == 400) {
                            $.each(res.fields, function(key, val) {
                                $.each(val, function(idx, row) {
                                    alertShow(val[idx], 'danger');
                                })
                            })
                        } else {
                            $('.alert-wrapper').empty();
                            alertShow(res.message, 'danger');
                        }
                    }
                });
            })
        })
    </script>
</body>

</html>
