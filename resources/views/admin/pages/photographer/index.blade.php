@extends('admin.part.app')
@section('title')
    @lang('photographer')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('photographer')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('photographer.index') }}">@lang('photographer')</a>
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
                                    <h4 class="card-title">@lang('photographer')</h4>
                                </div>
                                <div class="text-right">
                                    <div class="form-gruop">
                                        <button class="btn btn-outline-primary button_modal" type="button"
                                            data-toggle="modal" id="" data-target="#full-modal-stem"><span><i
                                                    class="fa fa-plus"></i>@lang('add')</span>
                                        </button>
                                    </div>
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
                                                <label for="s_name">@lang('name')</label>
                                                <input id="s_name" type="text" class="search_input form-control"
                                                    placeholder="@lang('name')">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="city_uuid">@lang('city')</label>
                                                <select name="city_uuid" id="s_city" class="search_input form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
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
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="area_uuid">@lang('date')</label>
                                                <input name="date" type="date" id="s_date"
                                                    class="search_input form-control">

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
                                            <th>@lang('cities')</th>
                                            <th>@lang('date')</th>
                                            <th>@lang('time')</th>
                                            <th>@lang('photographer')</th>
                                            <th style="width: 225px;">@lang('actions')</th>
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
    <div class="modal fade" class="full-modal-stem" id="full-modal-stem" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('photographer.store') }}" method="POST" id="add_model_form"
                    class="add-mode-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('country')</label>
                                    <select name="country_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('country')</option>
                                        @foreach ($country as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('city')</label>
                                    <select name="city_uuid" id="edit_city" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('city')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('area')</label>
                                    <select name="area_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('area')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('user')</label>
                                    <select name="user_uuid" id="" class="form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('users')</option>
                                        @foreach ($users as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->phone }} </option>
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
                                    <label for="">@lang('date')</label>
                                    <input type="date" name="date" class="form-control">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('phone')</label>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="@lang('phone')">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('type_content')</label>
                                    <select class="form-control type_content" name="typeContent" id=""
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('select')</option>
                                        @foreach ($type as $key => $item)
                                            <option value="{{ $key }}">@lang($item)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('time')</label>
                                    <input type="time" class="form-control" name="time" id="">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 content-1" style="display: none" id="">
                                <div class="form-group">
                                    <label for="">@lang('image')</label>
                                    <input type="file" class="file form-control" name="image">
                                </div>
                            </div>
                            <div class="col-md-6 content-2" style="display: none" id="">
                                <div class="form-group">
                                    <label for="">@lang('video')</label>
                                    <input type="file" class="file form-control" name="video">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">@lang('close')</button>
                            <button class="btn btn-primary">@lang('add')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('edit')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('photographer.update') }}" method="POST" id="form_edit" class=""
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="uuid" id="uuid" class="form-control" />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('country')</label>
                                    <select name="country_uuid" id="edit_country" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('country')</option>
                                        @foreach ($country as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('city')</label>
                                    <select name="city_uuid" id="edit_city_uuid" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('city')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('area')</label>
                                    <select name="area_uuid" id="edit_area" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('area')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('user')</label>
                                    <select name="user_uuid" id="edit_user_uuid" class="form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('users')</option>
                                        @foreach ($users as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->phone }} </option>
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
                                    <label for="">@lang('date')</label>
                                    <input type="date" name="date" class="form-control" id="date">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('phone')</label>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        placeholder="@lang('phone')">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('type_content')</label>
                                    <select class="form-control type_content" name="typeContent" id=""
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('select')</option>
                                        @foreach ($type as $key => $item)
                                            <option value="{{ $key }}">@lang($item)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('type_content')</label>
                                    <input type="time" class="form-control" name="time" id="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 content-1" style="display: none" id="">
                                <div class="form-group">
                                    <label for="">@lang('image')</label>
                                    <input type="file" class="file form-control" name="image">
                                </div>
                            </div>
                            <div class="col-md-6 content-2" style="display: none" id="">
                                <div class="form-group">
                                    <label for="">@lang('video')</label>
                                    <input type="file" class="file form-control" name="video">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">@lang('close')</button>
                            <button class="btn btn-primary">@lang('add')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script>
        $('.type_content').change(function(e) {
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
                url: '{{ route('photographer.getData', app()->getLocale()) }}',
                data: function(d) {
                    d.city_uuid = $('#s_city').val();
                    d.area_uuid = $('#s_area').val();
                    d.user_uuid = $('#s_name').val();
                    d.phone = $('#s_phone').val()
                    d.status = $('#s_date').val();

                }
            },
            columns: [{
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
                    data: 'time',
                    name: 'time',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'photographer',
                    name: 'photographer',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]

        });


        $(document).ready(function() {
            $(document).on('click', '.btn_edit', function(event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                $('#edit_user_uuid').val(button.data('user_uuid')).trigger('change');
                $('#phone').val(button.data('phone'));
                $('#date').val(button.data('date'));
                $('#time').val(button.data('time'));
                $('#edit_country').val(button.data('country_uuid'));
                $('#edit_city_uuid').append('<option value="' + button.data('city_uuid') + '" selected>' + button
                    .data('city_name') + '</option>');
                $('#edit_area').append('<option value="' + button.data('area_uuid') + '" selected>' + button
                    .data('area_name') + '</option>');
                $('#uuid').val(uuid);

                @foreach (locales() as $key => $value)
                    $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                @endforeach

            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('select[name="city_uuid"]').on('change', function() {

                var city_uuid = $(this).val();
                console.log(city_uuid)
                if (city_uuid) {
                    $.ajax({
                        url: "users/area" + "/" + city_uuid,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="area_uuid"]').empty();

                            $('select[name="area_uuid"]').append(`
                             <option selected  disabled>@lang('select') @lang('area')</option>
                             `)
                            $.each(data, function(key, value) {
                                $('select[name="area_uuid"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });


            $('select[name="country_uuid"]').on('change', function() {
                var country_uuid = $(this).val();
                console.log(country_uuid);
                if (country_uuid) {
                    $.ajax({
                        url: "users/country" + "/" + country_uuid,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log('ccc')
                            $('select[name="city_uuid"]').empty();
                            $('select[name="city_uuid"]').append(`
                             <option selected  disabled>@lang('select') @lang('area')</option>
                             `)
                            $('select[name="area_uuid"]').empty();
                            $.each(data, function(key, value) {
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
