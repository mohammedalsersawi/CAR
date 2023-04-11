@extends('part.app')
@section('title')
    @lang('Order Appointment')
@endsection
@section('styles')
@endsection
@section('content')
    @vite('resources/js/app.js')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('Order Appointment')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('OrderAppointment.index') }}">@lang('Order Appointment')</a>
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
                                    <h4 class="card-title">@lang('Order Appointment')</h4>
                                </div>

                            </div>
                            <div class="card-body">
                                <form id="search_form">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_phone">@lang('phone')</label>
                                                <input id="s_phone" type="text" class="search_input form-control"
                                                       placeholder="@lang('phone')">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="area_uuid">@lang('date')</label>
                                                <input name="date" type="date" id="s_date"
                                                       class="search_input form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="status">@lang('status')</label>
                                                <select id="s_status" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('status')</option>
                                                    <option value="1"> @lang('pending') </option>
                                                    <option value="2"> @lang('accepted') </option>
                                                    <option value="3"> @lang('complete') </option>
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
                                        <th>#</th>
                                        <th>@lang('phone')</th>
                                        <th>@lang('area')</th>
                                        <th>@lang('city')</th>
                                        <th>@lang('date')</th>
                                        <th>@lang('type')</th>
                                        <th>@lang('time')</th>
                                        <th>@lang('status')</th>


                                    </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <!-- Modal -->

{{--    <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"--}}
{{--         aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-lg" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('accept')</h5>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <form action="{{ route('OrderAppointment.accept') }}" method="POST" id="form_edit" class=""--}}
{{--                      enctype="multipart/form-data">--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="row">--}}
{{--                            <input type="hidden" name="uuid" id="uuid_appointment" class="form-control"/>--}}
{{--                        </div>--}}


{{--                        <div class="row">--}}

{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">@lang('user')</label>--}}
{{--                                    <select name="photographer_uuid" id="photographer_uuid" class="form-control"--}}
{{--                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">--}}
{{--                                    </select>--}}
{{--                                    <div class="invalid-feedback"></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-secondary"--}}
{{--                                    data-dismiss="modal">@lang('close')</button>--}}
{{--                            <button class="btn btn-primary btn-success">@lang('accept')</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="modal fade" id="add-car"tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.appointment.ads') }}" method="POST" id="add-mode-form" class="add-mode-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="appointment_uuid" id="uuid_appointment_car"
                                       class="form-control"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">@lang('phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('phone')"
                                           name="phone" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">@lang('price')</label>
                                    <input type="text" class="form-control" placeholder="@lang('price')"
                                           name="price" id="price">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">@lang('brand')</label>
                                    <select name="brand_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('brand')</option>
                                        @foreach ($Brand as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Model')</label>
                                    <select name="model_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Model')</option>
                                        @foreach ($ModelCar as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_interior')</label>
                                    <select name="color_interior_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_interior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                <div
                                                    style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                </div>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_exterior')</label>
                                    <select name="color_exterior_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_exterior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}">
                                                <h1>{{ $itemm->name }} </h1>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage">@lang('mileage')</label>
                                    <input type="text" class="form-control" placeholder="@lang('mileage')"
                                           name="mileage" id="mileage">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Engine')</label>
                                    <select name="engine_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Engine')</option>
                                        @foreach ($Engine as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="year_to">@lang('year')</label>
                                    <select name="year" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('select')</option>
                                        @isset($year)
                                            @for ($i = $year->from; $i <= $year->to ;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        @endisset

                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Transmission')</label>
                                    <select name="transmission_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Transmission')</option>
                                        @foreach ($Transmission as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('fueltype')</label>
                                    <select name="fule_type_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('fueltype')</option>
                                        @foreach ($FuelType as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">@lang('image')</label>
                                    <input type="file" accept="image/*" class="form-control"
                                           placeholder="@lang('image')" name="image[]" multiple id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">@lang('video')</label>
                                <input type="file" accept="video/*" class="form-control"
                                       placeholder="@lang('video')" name="video[]" multiple id="video">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="text-right mb-2">
                                        <button class="add_row btn btn-sm btn-dark">@lang('add row')</button>
                                    </div>
                                    <div class="row_data">
                                        <div class="row mb-12">
                                            <div class="col-md-11">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input name="specification[]" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-danger  remove_row">@lang('delete')</button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
{{--                    <div id="map"></div>--}}
{{--                    <input type="hidden" name="lat" id="lat">--}}
{{--                    <input type="hidden" name="lng" id="lng">--}}

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button class="btn btn-primary">@lang('add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        $('.type_content').change(function (e) {
            debugger;
            e.preventDefault();
            var value = $(this).val();
            if (value == 1) {
                $(".content-1").css("display", "block");
                $(".content-2").css("display", "none");
            } else if (value == 2) {
                $(".content-1").css("display", "block");
                $(".content-2").css("display", "block");
            }
        });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //bindTable
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            "oLanguage": {
                @if (app()->isLocale('ar'))
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
                @endif // "oPaginate": {"sPrevious": '<-', "sNext": '->'},
            },
            ajax: {
                url: '{{ route('user.appointment.getData', app()->getLocale()) }}',
                data: function (d) {
                    // d.city_uuid = $('#s_city').val();
                    // d.area_uuid = $('#s_area').val();
                    // d.photographer_uuid = $('#s_name').val();
                    d.phone = $('#s_phone').val()
                    d.date = $('#s_date').val();
                    d.status = $('#s_status').val();


                }
            },
            columns: [

                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
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

                },
                {
                    data: 'area_name',
                    name: 'area_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type_media',
                    name: 'type_media',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'time',
                    name: 'time',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'StatusAppointment',
                    name: 'StatusAppointment',
                    orderable: false,
                    searchable: false
                },



            ]

        });

        $(document).ready(function () {
            $(document).on('click', '.btn_accept', function (event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                var url = "appointment/accept";
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        'uuid': uuid,
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

            });
        });
        $(document).ready(function () {
            $(document).on('click', '.add-car', function (event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                $('#uuid_appointment_car').val(uuid);


            });
        });
    </script>


    <script>
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
            $('select[name="country_uuid"]').on('change', function () {
                var country_uuid = $(this).val();
                console.log(country_uuid);
                if (country_uuid) {
                    $.ajax({
                        url: "users/country" + "/" + country_uuid,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            console.log('ccc')
                            $('select[name="city_uuid"]').empty();
                            $('select[name="city_uuid"]').append(`
                             <option selected  disabled>@lang('select') @lang('area')</option>
                             `)
                            $('select[name="area_uuid"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="city_uuid"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endsection
