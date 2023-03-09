@extends('admin.part.app')
@section('users')
    @lang('users')
@endsection
@section('styles')
    <style>
        #map {
            height: 300px;
        }
    </style>
    <style>
        #map2 {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('city')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('usertype.index') }}">@lang('users')</a>
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
                                    <h4 class="card-title">@lang('users')</h4>
                                </div>
                                <div class="text-right">
                                    <div class="form-gruop">
                                        <button class="btn btn-outline-primary button_modal" type="button"
                                            data-toggle="modal" id="addd" data-target="#full-modal-stem"><span><i
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
                                                <label for="city_id">@lang('city')</label>
                                                <select name="city_id" id="s_city" class="search_input form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                    <option selected disabled>Select @lang('city')</option>
                                                    @foreach ($cities as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="area_id">@lang('area')</label>
                                                <select name="area_id" id="s_area" class="search_input form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_user_type_id">@lang('type')</label>
                                                <select id="s_user_type_id" class="search_input form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                    <option selected disabled>Select @lang('type')</option>
                                                    @foreach ($user as $item)
                                                        <option value="{{ $item->id }}"> {{ $item->Name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('Discount Store Type')</label>
                                                <select id="s_discount_type_id" class="search_input form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('Discount Store Type')</option>
                                                    @foreach ($type as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
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
                                            <th>@lang('name')</th>
                                            <th>@lang('phone')</th>
                                            <th>@lang('image')</th>
                                            <th>@lang('about')</th>
                                            <th>@lang('city')</th>
                                            <th>@lang('area')</th>
                                            <th>@lang('type')</th>
                                            <th>@lang('Discount Store Type')</th>
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
                <form action="{{ route('usertype.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">@lang('phone')</label>
                                    <input type="number" class="form-control" placeholder="@lang('phone')"
                                        name="phone" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('name')</label>
                                    <input type="text" class="form-control" placeholder="@lang('name')"
                                        name="name" id="">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about">@lang('about')
                                    </label>
                                    <input type="text" class="form-control" placeholder="@lang('about')"
                                        name="about" id="about">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Discount Store Type')</label>
                                    <select name="discount_type_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Discount Store Type')</option>
                                        @foreach ($type as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('country')</label>
                                    <select name="country_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('country')</option>
                                        @foreach ($country as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('city')</label>
                                    <select name="city_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('city')</option>

                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('area')</label>
                                    <select name="area_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">

                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('type')</label>
                                    <select name="user_type_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('type')</option>
                                        @foreach ($user as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->Name }} </option>
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
                                    <label for="phone">@lang('password')</label>
                                    <input type="password" class="form-control" placeholder="@lang('password')"
                                        name="password" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">@lang('image')</label>
                                    <input type="file" accept="image/*" class="form-control"
                                        placeholder="@lang('image')" name="image" id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>


                        <div id="map"></div>
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
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


    <!-- Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('usertype.update') }}" method="POST" id="form_edit" class="form_edit"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('name')</label>
                                    <input type="text" class="form-control" placeholder="@lang('name')"
                                        name="name" id="edit_name">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">@lang('phone')</label>
                                    <input type="number" class="form-control" placeholder="@lang('phone')"
                                        name="phone" id="edit_phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="about">@lang('about')
                                    </label>
                                    <input type="text" class="form-control" placeholder="@lang('about') "
                                        name="about" id="edit_about">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Discount Store Type')</label>
                                    <select name="discount_type_id" id="discount_type_id" class="select form-control">
                                        <option selected disabled>Select @lang('Discount Store Type')</option>
                                        @foreach ($type as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('country')</label>
                                    <select name="country_id" id="edit_country" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('country')</option>
                                        @foreach ($country as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('city')</label>
                                    <select name="city_id" id="edit_city" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option disabled>Select @lang('city')</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('area')</label>
                                    <select name="area_id" id="edit_area" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('city')</option>

                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('type')</label>
                                    <select name="user_type_id" id="edit_type" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>Select @lang('type')</option>
                                        @foreach ($user as $itemm)
                                            <option value="{{ $itemm->id }}"> {{ $itemm->Name }} </option>
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image">@lang('image')</label>
                                    <input type="file" accept="image/*" class="form-control"
                                        placeholder="@lang('image')" name="image" id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>




                        <div id="map2"></div>
                        <input type="hidden" name="lat" id="edit_lat">
                        <input type="hidden" name="lng" id="edit_lng">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">@lang('close')</button>
                            <button class="btn btn-primary">@lang('save changes')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>




    </div>
@endsection
@section('scripts')
    <script>
        var map2 = L.map('map2').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map2);

        var lon;
        var lat;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";

        }

        function showPosition(position) {

            function onMapClick(e) {
                $('#edit_lat').val(e.latlng.lat)
                $('#edit_lng').val(e.latlng.lng)
                console.log(e);
                var layar = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map2)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();

            }

            map2.on('click', onMapClick);
        }
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
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
            searching: false,
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
                url: '{{ route('usertype.getData', app()->getLocale()) }}',
                data: function(d) {
                    d.phone = $('#s_phone').val();
                    d.number = $('#s_number').val();
                    d.city_id = $('#s_city').val();
                    d.area_id = $('#s_area').val();
                    d.user_type_id = $('#s_user_type_id').val();
                    d.discount_type_id = $('#s_discount_type_id').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    "data": 'image',
                    "name": 'image',
                    render: function(data, type, full, meta) {
                        return (data) ?
                            `<img src="{{ asset('uploads/${data}') }}" style="width:100px;height:100px;" class="img-fluid img-thumbnail">` :
                            ' no image';
                    },
                },

                {
                    data: 'about',
                    name: 'about'
                },
                {
                    data: 'city_name',
                    name: 'city'
                },
                {
                    data: 'area_name',
                    name: 'area'
                },
                {
                    data: 'type_name',
                    name: 'Type'
                },
                {
                    data: 'DiscountStoreType',
                    name: 'DiscountStoreType'
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
                // map2.eachLayer(function (layer) {
                //     map2.removeLayer(layer);
                // });
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var id = button.data('id');
                $('#edit_city').append('<option value="' + button.data('city') + '" selected>' +
                    button.data('city_name') + '</option>');

                // $('#edit_country').append('<option value="' + button.data('country') + '" selected>' +
                //     button.data('country_name') + '</option>');
                $('#edit_area').append('<option value="' + button.data('area') + '" selected>' +
                    button.data('area_name') + '</option>');
                $('#edit_country').val(button.data('country'));
                $('#edit_city').val(button.data('city'));
                $('#edit_area').val(button.data('area'));
                // $('#edit_city').val(button.data('city'));

                //
                //
                //
                //
                // $('#edit_area').val(button.data('area')).trigger('change');
                //
                // $('#edit_area').append('<option value="' + button.data('area') + '" selected>' +
                //     button.data('area_name') + '</option>');



                $('#edit_type').val(button.data('user_type_id')).trigger('change');
                $('#edit_phone').val(button.data('phone'));
                $('#edit_number').val(button.data('number'));
                $('#edit_lat').val(button.data('lat'))
                $('#edit_lng').val(button.data('lng'))
                $('#edit_name').val(button.data('name'))
                $('#id').val(id);
                $('#edit_about').val(button.data('about'))

                L.marker([button.data('lat'), button.data('lng')]).addTo(map2)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();

            });
            $(document).on('click', '#addd', function() {
                // map.eachLayer(function (layer) {
                //     map.removeLayer(layer);
                // });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="city_id"]').on('change', function() {

                var city_id = $(this).val();
                console.log(city_id)
                if (city_id) {
                    $.ajax({
                        url: "usertype/area" + "/" + city_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="area_id"]').empty();

                            $('select[name="area_id"]').append(`
                                 <option selected  disabled>Select @lang('area')</option>
                                 `)
                            $.each(data, function(key, value) {
                                $('select[name="area_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });


            $('select[name="country_id"]').on('change', function() {
                var country_id = $(this).val();
                console.log(country_id);
                if (country_id) {
                    $.ajax({
                        url: "usertype/country" + "/" + country_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log('ccc')
                            $('select[name="city_id"]').empty();
                            $('select[name="city_id"]').append(`
                                 <option selected  disabled>Select @lang('area')</option>
                                 `)
                            $('select[name="area_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
        $('#edit_modal').on('hidden.bs.modal', function() {
            $('select[name="area_id"]').empty();

            console.log('ddd');
        })
    </script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var lon;
        var lat;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";

        }
        //
        function showPosition(position) {





            function onMapClick(e) {
                $('#lat').val(e.latlng.lat)
                $('#lng').val(e.latlng.lng)
                console.log(e.latlng.lng);
                // map.eachLayer(function (layer) {
                //     map.removeLayer(layer);
                // });
                L.marker([e.latlng.lat, e.latlng.lng]).addTo(map)
                    .openPopup();

            }

            map.on('click', onMapClick);




        }
    </script>
@endsection
