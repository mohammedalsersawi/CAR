<!DOCTYPE html>
<html class="loaded semi-dark-layout" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Aqar</title>
    <link rel="apple-touch-icon" href="{{ asset('dashboard/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboard/app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/vendors' . rtl_assets() . '.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/colors.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/components.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/themes/bordered-layout.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/themes/semi-dark-layout.min.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/plugins/extensions/ext-component-toastr.min.css') }}">
    <!-- END: Page CSS-->
    @yield('styles')

    <!-- BEGIN: Custom CSS-->
    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <link rel="stylesheet" type="text/css"
            href="{{ asset('dashboard/app-assets/css' . rtl_assets() . '/custom' . rtl_assets() . '.min.css') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/assets/css/style' . rtl_assets() . '.css') }}">
    <!-- END: Custom CSS-->

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav
        class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow bg-primary navbar-dark">
        <div class="navbar-container d-flex content">
            <ul class="nav navbar-nav align-items-center ml-auto">
                <li class="nav-item dropdown dropdown-language">
                    <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="selected-language">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                data-language="{{ $localeCode }}">{{ $properties['native'] }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user"
                        href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="font-weight-bolder">admin</span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href=""><i class="mr-50" data-feather="user"></i>
                            Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mr-50" data-feather="power"></i>Logout</a>
                        <form id="logout-form" action="" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-accordion menu-shadow menu-dark" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ url('admin') }}"><span
                            class="brand-logo">

                            <img src="{{ asset('dashboard/app-assets/images/logo/Logo.svg') }}">
                        </span>
                    </a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('model') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">الموديل</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('engines') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">المحركات</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('fuel_type') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">نوع الوقود</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('brand') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">brand</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('room.index') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">@lang('Room')</span>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="d-flex align-items-center" href="{{ route('color.index') }}">
                        <i data-feather="file-text"></i><span class="menu-title text-truncate">@lang('Color')</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        @yield('content')
    </div>
    <!-- END: Content-->


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <script></script>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('dashboard/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('dashboard/app-assets/js/core/ap`-menu.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/js/core/app.min.js') }}"></script>
    <script src="{{ asset('dashboard/app-assets/js/scripts/customizer.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    {{-- <script src="{{asset('dashboard/app-assets/js/scripts/tables/table-datatables-basic.min.js')}}"></script> --}}
    <script src="{{ asset('dashboard/app-assets/js/scripts/extensions/ext-component-toastr.min.js') }}"></script>
    s
    @yield('js')

    <script>

        var isRtl = '{{LaravelLocalization::getCurrentLocaleDirection()}}' === 'rtl';

        var selectedIds = function () {
            return $("input[name='table_ids[]']:checked").map(function () {
                return this.value;
            }).get();
        };
        $('select').select2({
            dir: '{{LaravelLocalization::getCurrentLocaleDirection()}}',
            placeholder: "@lang('select')",
        });
        $(document).ready(function () {
            $(document).on('click', "#export_btn", function (e) {
                e.preventDefault();
                window.open(url + 'export?' + $('#search_form').serialize(), '_blank');
            });

            $(document).on('click', "#chart_btn", function (e) {
                e.preventDefault();
                window.open(url + 'chart?' + $('#search_form').serialize(), '_blank');
            });

            $("#advance_search_btn").click(function (e) {
                e.preventDefault();
                $('#advance_search_div').toggle(500);
            });

            $(document).on('change', "#select_all", function (e) {
                var delete_btn = $('#delete_btn'), export_btn = $('#export_btn'),
                    chart_btn = $('#chart_btn'), all_status_btn = $('.all_status_btn'), table_ids = $('.table_ids');
                this.checked ? table_ids.each(function () {
                    this.checked = true
                }) : table_ids.each(function () {
                    this.checked = false
                })
                delete_btn.attr('data-id', selectedIds().join());
                export_btn.attr('data-id', selectedIds().join());
                chart_btn.attr('data-id', selectedIds().join());
                all_status_btn.attr('data-id', selectedIds().join());
                if (selectedIds().join().length) {
                    delete_btn.prop('disabled', '');
                    all_status_btn.prop('disabled', '');
                } else {
                    delete_btn.prop('disabled', 'disabled');
                    all_status_btn.prop('disabled', 'disabled');
                }
            });

            $(document).on('change', ".table_ids", function (e) {
                var delete_btn = $('#delete_btn'), select_all = $('#select_all'), all_status_btn = $('.all_status_btn');
                if ($(".table_ids:checked").length === $(".table_ids").length) {
                    select_all.prop("checked", true)
                } else {
                    select_all.prop("checked", false)
                }
                delete_btn.attr('data-id', selectedIds().join());
                all_status_btn.attr('data-id', selectedIds().join());
                console.log(selectedIds().join().length)
                if (selectedIds().join().length) {
                    delete_btn.prop('disabled', '');
                    all_status_btn.prop('disabled', '');
                } else {
                    delete_btn.prop('disabled', 'disabled');
                    all_status_btn.prop('disabled', 'disabled');
                }
            });

            $('#search_btn').on('click', function (e) {
                oTable.draw();
                e.preventDefault();
            });

            $('#clear_btn').on('click', function (e) {
                e.preventDefault();
                $('.search_input').val("").trigger("change")
                oTable.draw();
            });

            $(document).on("click", ".delete-btn", function (e) {
                e.preventDefault();
                var urls = url;
                if (selectedIds().join().length) {
                    urls += selectedIds().join();
                } else {
                    urls += $(this).data('id');
                }
                Swal.fire({
                    title: '@lang('delete_confirmation')',
                    text: '@lang('confirm_delete')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '@lang('yes')',
                    cancelButtonText: '@lang('cancel')',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger'
                    },
                    buttonsStyling: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: urls,
                            method: 'DELETE',
                            type: 'DELETE',
                            data: {
                                _token: '{{csrf_token()}}'
                            },
                        }).done(function (data) {
                            if (data.status) {
                                toastr.success('@lang('deleted')', '', {
                                    rtl: isRtl
                                });
                                oTable.draw();
                                $('#select_all').prop('checked', false).trigger('change')
                            } else {
                                toastr.warning('@lang('not_deleted')', '', {
                                    rtl: isRtl
                                });
                            }

                        }).fail(function () {
                            toastr.error('@lang('something_wrong')', '', {
                                rtl: isRtl
                            });
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.info('@lang('delete_canceled')', '', {
                            rtl: isRtl
                        })
                    }
                });
            });
            $(document).on("click", ".status_btn", function (e) {
                e.preventDefault();
                var ids = $(this).data('id');
                var status = $(this).val();
                var urls = url + 'update_status';
                Swal.fire({
                    title: '@lang('update_confirmation')',
                    text: '@lang('confirm_update')',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '@lang('yes')',
                    cancelButtonText: '@lang('cancel')',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger'
                    },
                    buttonsStyling: true
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: urls,
                            method: 'PUT',
                            type: 'PUT',
                            data: {
                                ids: ids,
                                status: status,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (data) {
                                if (data.status) {
                                    toastr.success('@lang('done_successfully')');
                                    oTable.draw();
                                } else {
                                    toastr.error('@lang('something_wrong')');
                                }
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.info('@lang('update_canceled')', '', {
                            rtl: isRtl
                        })
                    }
                });
            });

            $('#create_modal,#edit_modal').on('hide.bs.modal', function (event) {
                var form = $(this).find('form');
                form.find('select').val('').trigger("change")
                form[0].reset();
                $('.submit_btn').removeAttr('disabled');
                $('.fa-spinner.fa-spin').hide();
                $(".is-invalid").removeClass("is-invalid");
                $(".invalid-feedback").html("");
            })

            $(document).on('submit', '.ajax_form', function (e) {
                // $('.submit_btn').prop('disabled', true);
                e.preventDefault();
                var form = $(this);
                var url = $(this).attr('action');
                var method = $(this).attr('method');
                var reset = $(this).data('reset');
                var Data = new FormData(this);
                $('.submit_btn').attr('disabled', 'disabled');
                $('.fa-spinner.fa-spin').show();
                $.ajax({
                    url: url,
                    type: method,
                    data: Data,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('.invalid-feedback').html('');
                        $('.is-invalid ').removeClass('is-invalid');
                        form.removeClass('was-validated');
                    }
                }).done(function (data) {
                    if (data.status) {
                        toastr.success('@lang('done_successfully')', '', {
                            rtl: isRtl
                        });
                        if (reset === true) {
                            console.log(isRtl)
                            form[0].reset();
                            $('.submit_btn').removeAttr('disabled');
                            $('.fa-spinner.fa-spin').hide();
                            $('.modal').modal('hide');
                            oTable.draw();
                        } else {
                            $('.submit_btn').removeAttr('disabled');
                            $('.fa-spinner.fa-spin').hide();
                            $('.modal').modal('hide');
                            oTable.draw();

                            // var url = $('#cancel_btn').attr('href');
                            // window.location.replace(url);
                        }
                    } else {
                        if (data.message) {
                            toastr.error(data.message, '', {
                                rtl: isRtl
                            });
                        } else {
                            toastr.error('@lang('something_wrong')', '', {
                                rtl: isRtl
                            });
                        }
                        $('.submit_btn').removeAttr('disabled');
                        $('.fa-spinner.fa-spin').hide();
                    }
                }).fail(function (data) {
                    if (data.status === 422) {
                        var response = data.responseJSON;
                        $.each(response.errors, function (key, value) {
                            var str = (key.split("."));
                            if (str[1] === '0') {
                                key = str[0] + '[]';
                            }
                            $('[name="' + key + '"], [name="' + key + '[]"]').addClass('is-invalid');
                            $('[name="' + key + '"], [name="' + key + '[]"]').closest('.form-group').find('.invalid-feedback').html(value[0]);
                        });
                    } else {
                        toastr.error('@lang('something_wrong')', '', {
                            rtl: isRtl
                        });
                    }
                    $('.submit_btn').removeAttr('disabled');
                    $('.fa-spinner.fa-spin').hide();

                });
            });



            $('#datatable').on('draw', function () {
                $("#select_all").prop("checked", false)
                $('#delete_btn').prop('disabled', 'disabled');
                $('.status_btn').prop('disabled', 'disabled');
            });

        });


    </script>
    @yield('scripts')
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>




</body>
<!-- END: Body-->

</html>
