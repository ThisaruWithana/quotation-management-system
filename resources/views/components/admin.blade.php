<!--
/*!
 *   AdminLTE With Laravel
 *   Author: Nihir Zala
 *   Website: https://nihirzala.vercel.app
 *   License: Open source - MIT <https://opensource.org/licenses/MIT>
 */
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title', 'Admin') | {{ config('app.name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/favicon/site.webmanifest') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css?ver=0.1') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- toast -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/toastr.min.css') }}"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/style.css?ver=0.1') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/bs-stepper.min.css') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/bootstrap-select.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/dist/css/fixedHeader.dataTables.min.css') }}">

    <link href="{{ asset('admin/dist/css/scrollbox.min.css') }}" rel="stylesheet" />
    
    <style>
        .required{
            color:red;
        }

        .info-lb{
            display: inline !important;
        }
        .item-img{
            width: 200px;
            height: 200px;
        }
        .item-table{
            display: block;
            overflow: auto !important;
        }
        .item-div{
            width: 100% !important;
        }
        .editable {
        background-color: #f7dc6f;
        }

    </style>
<style>
            .dataTables_scrollHeadInner{
                width: 100% !important;
            }
            .dataTables_scrollHeadInner  .table{
                width: 100% !important;
            }
            div.dataTables_wrapper div.dataTables_info {
                padding-top: .85em;
                text-align: left;
                padding-bottom: 30px;
            }

            .card-dark{
                background: #FDFDFD;
                padding: 15px;
                border: 1px solid #ddd;
                box-shadow: none;
            }

            .form-control:disabled, .form-control[readonly] {
                background-color: #e9ecef;
                opacity: 1;
                border: 1px solid #ced4da !important;
            }
            .bootstrap-select.disabled, .bootstrap-select > .disabled {
                cursor: not-allowed;
                border: 1px solid #ced4da !important;
                border-radius: 10px;
            }

            .bootstrap-select > .dropdown-toggle{
                border: 1px solid #ced4da !important;
            }
            .form-group .bootstrap-select, .form-horizontal .bootstrap-select, .form-inline .bootstrap-select {
                padding: 0;
            }
        </style>
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed {{ Auth::user()->mode }}-mode">

    <div class="wrapper">
        <!-- Navbar -->
        <x-navbar />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-{{ Auth::user()->mode }}-primary elevation-4">
            <!-- Brand Logo -->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::user()->avatar != null)
                            <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                        @else
                            <img src="{{ asset('admin/dist/img/profile.png') }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('admin.dashboard') }}" class="d-block">{{ config('app.name') }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <x-sidebar />
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                {{ $slot }}
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
       
        </div>
        <!-- <strong>Copyright © {{ date('Y') }}</strong> All rights reserved. -->
    </footer>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('admin/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('admin/dist/js/pages/dashboard.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

    
    <script src="{{ asset('admin/dist/js/cute-alert.js') }}"></script>
    <script src="{{ asset('admin/dist/js/bs-stepper.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js" integrity="sha512-rCjfoab9CVKOH/w/T6GbBxnAH5Azhy4+q1EXW5XEURefHbIkRbQ++ZR+GBClo3/d3q583X/gO4FKmOFuhkKrdA==" crossorigin="anonymous"></script>
    <script src="{{ asset('admin/dist/js/scrollbox.min.js') }}"></script>


    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('admin/dist/js/bootstrap-select.min.js') }}"></script>

    <!-- Fixed Headers -->
    <script src="{{ asset('admin/dist/js/dataTables.fixedHeader.min.js') }}"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


    <!-- Toast cdn -->
    <script src="{{ asset('admin/dist/js/toastr.min.js') }}"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Toastr alerts
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        }
        
        function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.item-img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            
    </script>

    <script type="text/javascript">
        $(function () {
            var $container = $('#container'),
                i = 1;

            $container
                .on('reach.scrollbox', function () {
                    if (i < 6) {
                        // emulate XHR
                        window.setTimeout(function () {
                            $container.append('<div class="test-div">This is a test div #' + i ++ + '</div>');
                            $container.scrollbox('update'); // recalculate bar height and position
                        }, 300);
                    }
                })
                .scrollbox({
                    buffer: 50 // position from bottom when reach.scrollbox will be triggered
                });
        });
    </script>

    <script>

        function handleNestedModal(modalSelector) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(modalSelector).css('z-index', zIndex); 
            setTimeout(function () {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        }

        $(document).on('show.bs.modal', '.modal', function () {
            handleNestedModal(this); 
            $('body').addClass('modal-open'); 
        });


        $(document).on('hidden.bs.modal', '.modal', function () {
            if ($('.modal:visible').length) { 
                $('body').addClass('modal-open');
            } else {
                $('body').removeClass('modal-open'); 
            }
    });
    </script>

    <x-alert />
    @yield('js')
</body>

</html>
