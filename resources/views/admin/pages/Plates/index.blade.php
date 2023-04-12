@extends('part.app')
@section('title')
    @lang('Plates')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('Plates')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('Plates.index') }}">@lang('Plates')</a>
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
                                    <h4 class="card-title">@lang('Plates')</h4>
                                </div>
                                @can('Plate.create')
                                    <div class="text-right">
                                        <div class="form-group">
                                            <button class="btn btn-outline-primary button_modal" type="button"
                                                    data-toggle="modal" id="" data-target="#full-modal-stem"><span><i
                                                            class="fa fa-plus"></i>@lang('add')</span>
                                            </button>
                                        </div>
                                    </div>
                                @endcan
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
                                                <label for="s_price">@lang('price')</label>
                                                <input id="s_price" type="text" class="search_input form-control"
                                                       placeholder="@lang('price')">
                                            </div>
                                        </div>
                                        {{--                                        <div class="col-3">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label for="s_numbertow">@lang('number tow')</label>--}}
                                        {{--                                                <input id="s_numbertow" type="text" class="search_input form-control"--}}
                                        {{--                                                       placeholder="@lang('number tow')">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-3">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label for="s_textone">@lang('text one')</label>--}}
                                        {{--                                                <input id="s_textone" type="text" class="search_input form-control"--}}
                                        {{--                                                       placeholder="@lang('text one')">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        {{--                                        <div class="col-3">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label for="s_textrtow">@lang('text tow')</label>--}}
                                        {{--                                                <input id="s_textrtow" type="text" class="search_input form-control"--}}
                                        {{--                                                       placeholder="@lang('text tow')">--}}
                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="city_uuid">@lang('city')</label>
                                                <select id="s_city" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('city')</option>
                                                    @foreach ($cities as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">@lang('status')</label>
                                                <select id="s_status" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('status')</option>
                                                    <option value="0"> @lang('Nat_Sold') </option>
                                                    <option value="1"> @lang('Sold') </option>


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
                                        <th>@lang('user_name')</th>
                                        <th>@lang('city')</th>
                                        <th>@lang('numberone')</th>
                                        <th>@lang('numbertow')</th>
                                        <th>@lang('stringone')</th>
                                        <th>@lang('stringtow')</th>
                                        <th>@lang('phone')</th>
                                        <th>@lang('price')</th>
                                        <th>@lang('status')</th>
                                        @can('Plate.delete'||'Plate.update')
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
            </section>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" class="full-modal-stem" id="full-modal-stem" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')/h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="{{ route('Plates.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('numberone')</label>
                                    <input type="text" class="form-control" name="numberone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('stringone')</label>
                                    <input type="text" class="form-control" name="stringone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('numbertow')</label>
                                    <input type="text" class="form-control" name="numbertow">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('stringtow')</label>
                                    <input type="text" class="form-control" name="stringtow">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_uuid">@lang('user_name')</label>
                                    <select name="user_uuid" id="" class="form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('users')</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->uuid }}">
                                                {{ $item->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_uuid">@lang('cities')</label>
                                    <select id="" class="form-control" name="city_uuid"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('cities')</option>
                                        @foreach ($cities as $item)
                                            <option value="{{ $item->uuid }}">
                                                {{ $item->name }}
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
                                    <label for="">@lang('phone')</label>
                                    <input type="text" class="form-control" name="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('price')</label>
                                    <input type="text" class="form-control" name="price">
                                    <div class="invalid-feedback"></div>
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

    <!-- Modal -->
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
                <form action="{{ route('Plates.update') }}" method="POST" id="form_edit" class=""
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" class="form-control"/>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('numberone')</label>
                                    <input type="text" class="form-control" name="numberone" id="numberone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('stringone')</label>
                                    <input type="text" class="form-control" name="stringone" id="stringone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('numbertow')</label>
                                    <input type="text" class="form-control" name="numbertow" id="numbertow">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('stringtow')</label>
                                    <input type="text" class="form-control" name="stringtow" id="stringtow">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_uuid">@lang('user_name')</label>
                                    <select name="user_uuid" id="edit_user_uuid" class="form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        @foreach ($users as $item)
                                            <option value="{{ $item->uuid }}">
                                                {{ $item->phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_uuid">@lang('cities')</label>
                                    <select name="city_uuid" id="edit_city_uuid" class="form-control"
                                    >
                                        @foreach ($cities as $item)
                                            <option value="{{ $item->uuid }}">
                                                {{ $item->name }}
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
                                    <label for="">@lang('phone')</label>
                                    <input type="text" class="form-control" name="phone" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('price')</label>
                                    <input type="text" class="form-control" name="price" id="price">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button class="btn btn-primary">@lang('save changes')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
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
                url: '{{ route('Plates.getData', app()->getLocale()) }}',
                data: function (d) {
                    d.status = $('#s_status').val();
                    d.city_uuid = $('#s_city').val();
                    d.phone = $('#s_phone').val();
                    d.price = $('#s_price').val();

                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'city_name',
                    name: 'city_name'
                },
                {
                    data: 'numberone',
                    name: 'numberone'
                },
                {
                    data: 'numbertow',
                    name: 'numbertow'
                },
                {
                    data: 'stringone',
                    name: 'stringone'
                },
                {
                    data: 'stringtow',
                    name: 'stringtow'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'status',
                    name: 'status'
                },

                    @can('Plate.delete'||'Plate.update')
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                @endcan

            ]

        });


        $(document).ready(function () {
            $(document).on('click', '.btn_edit', function (event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                $('#uuid').val(uuid);
                $('#numberone').val(button.data('numberone'));
                $('#numbertow').val(button.data('numbertow'));
                $('#stringone').val(button.data('stringone'));
                $('#stringtow').val(button.data('stringtow'));
                $('#phone').val(button.data('phone'));
                $('#price').val(button.data('price'));
                $('#edit_user_uuid').val(button.data('user_uuid')).trigger('change');
                $('#edit_city_uuid').val(button.data('city_uuid')).trigger('change');
                @foreach (locales() as $key => $value)
                $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                @endforeach

            });
        });
    </script>
@endsection
