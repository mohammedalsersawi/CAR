@extends('part.app')
@section('title')
    @lang('user_order')
@endsection

@section('content')
    @vite('resources/js/app.js')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> @lang('user_order')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                            href="{{ route('orders.index') }}">@lang('user_order')</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <section id="">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="head-label">
                                    <h4 class="card-title">@lang('user_order')</h4>
                                </div>

                            </div>
                            <div class="card-body">
                                <form id="search_form">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_mobile">@lang('phone')</label>
                                                <input id="s_phone" type="text" class="search_input form-control"
                                                       placeholder="@lang('phone')">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="city_uuid">@lang('city')</label>
                                                <select name="city_uuid" id="s_city" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('city')</option>
                                                    @foreach ($cities as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="area_uuid">@lang('area')</label>
                                                <select name="area_uuid" id="s_area" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="status">@lang('status')</label>
                                                <select name="status" id="s_status" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('status')</option>

                                                    <option value="3"> @lang('pending') </option>
                                                    <option value="1"> @lang('accepted') </option>
                                                    <option value="2"> @lang('rejected') </option>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-3" style="margin-top: 20px">
                                            <div class="form-group">
                                                <button id="search_btn" class="btn btn-outline-info" type="submit">
                                                    <span><i class="fa fa-search"></i> @lang('search')</span>
                                                </button>
                                                <button id="clear_btn" class="btn btn-outline-secondary" type="submit">
                                                    <span><i class="fa fa-undo"></i> @lang('reset')</span>
                                                </button>
                                                <button id="btn_delete_all"
                                                        class="btn_delete_all btn btn-outline-danger " type="button">
                                                    <span><i class="fa fa-lg fa-trash-alt" aria-hidden="true"></i> @lang('delete')</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive card-datatable" style="padding: 20px">
                                <table class="table" id="datatable">
                                    <thead>
                                    <tr>
                                        <th><input name="select_all" id="example-select-all" type="checkbox"
                                                   onclick="CheckAll('box1', this)"/></th>
                                        <th>@lang('name')</th>
                                        <th>@lang('phone')</th>
                                        <th>@lang('city')</th>
                                        <th>@lang('area')</th>
                                        @can('order.acceptedOrRejected')
                                            <th>@lang('status')</th>
                                        @endcan
                                        @can('order.delete')
                                            <th style="width: 225px;">@lang('actions')</th>
                                        @endcan
                                    </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                    id="exampleModalLabel">
                                    @lang('user_order')
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="{{route('orders.delete','all')}}" method="POST">
                                @csrf
                                @method('delete')
                                <div class="modal-body">
                                    @lang('Are you sure to delete the items you checked?')
                                    <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">@lang('close')</button>
                                    <button type="submit" class="btn btn-danger">@lang('delete')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </div>

@endsection
@section('js')
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            "oLanguage": {
                @if(app()->isLocale('ar'))
                "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                "sLoadingRecords": "جارٍ التحميل...",
                "sProcessing": "جارٍ التحميل...",
                "sLengthMenu": "أظهر _MENU_ مدخلات",
                "sZeroRecords": "لم يعثر على أية سجلات",
                "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix": "",
                "sSearch": "ابحث:",
                "oAria": {
                    "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                },

                @endif// "oPaginate": {"sPrevious": '<-', "sNext": '->'},
                "oPaginate": {
                    // remove previous & next text from pagination
                    "sPrevious": '&nbsp;',
                    "sNext": '&nbsp;'
                }
            },
            'columnDefs': [
                {
                    "targets": 1,
                    "visible": false
                },
                {
                    'targets': 0,
                    "searchable": false,
                    "orderable": false
                },
            ],
            // dom: 'lrtip',

            ajax: {
                url: '{{route('orders.getData',app()->getLocale())}}',
                data: function (d) {
                    d.phone = $('#s_phone').val();

                    d.city_uuid = $('#s_city').val();
                    d.area_uuid = $('#s_area').val();
                    d.status = $('#s_status').val();

                }
            },
            columns: [
                {
                    "render": function (data, type, full, meta) {
                        return `<td><input type="checkbox" value="${data}" class="box1" ></td>
`;
                    },
                    name: 'checkbox',
                    data: 'checkbox',
                },

                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'city_name',
                    name: 'city_uuid',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'area_name',
                    name: 'area_name',
                    orderable: false,
                    searchable: false
                },
                    @can('order.acceptedOrRejected')
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                    @endcan
                    @can('order.delete')
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                },
                @endcan
            ]

        });
        $(document).ready(function () {
            $('select[name="city_uuid"]').on('change', function () {

                var city_uuid = $(this).val();
                console.log(city_uuid)
                if (city_uuid) {
                    $.ajax({
                        url: "users/area" + "/" + city_uuid,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="area_uuid"]').empty();

                            $('select[name="area_uuid"]').append(`
                                 <option selected  disabled>@lang('select') @lang('area')</option>
                                 `)
                            $.each(data, function (key, value) {
                                $('select[name="area_uuid"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
        $(document).on("click", ".btn-success", function (e) {
            var button = $(this)
            e.preventDefault();
            Swal.fire({
                title: '@lang('accept_confirmation')',
                text: '@lang('confirm_accept')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('yes')',
                cancelButtonText: '@lang('cancel')',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-success'
                },
                buttonsStyling: true
            }).then(function (result) {
                if (result.value) {
                    var uuid = button.data('uuid')
                    var url = window.location.href + '/' + 'accepted' + '/' + uuid;
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(function () {
                        toastr.success('@lang('accepted')', '', {
                            rtl: isRtl
                        });
                        table.draw()

                    }).fail(function () {
                        toastr.error('@lang('something_wrong')', '', {
                            rtl: isRtl
                        });
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.info('@lang('accept_canceled')', '', {
                        rtl: isRtl
                    })
                }
            });
        });
        $(document).on("click", ".btn-warning", function (e) {
            var button = $(this)
            e.preventDefault();
            Swal.fire({
                title: '@lang('rejected_confirmation')',
                text: '@lang('confirm_rejected')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('yes')',
                cancelButtonText: '@lang('cancel')',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-success'
                },
                buttonsStyling: true
            }).then(function (result) {
                if (result.value) {
                    var uuid = button.data('uuid')
                    var url = window.location.href + '/' + 'rejected' + '/' + uuid;
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(function () {
                        toastr.success('@lang('rejected')', '', {
                            rtl: isRtl
                        });
                        table.draw()

                    }).fail(function () {
                        toastr.error('@lang('something_wrong')', '', {
                            rtl: isRtl
                        });
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.info('@lang('rejected_canceled')', '', {
                        rtl: isRtl
                    })
                }
            });
        });
    </script>
@endsection
