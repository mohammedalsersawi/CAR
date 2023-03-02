@extends('admin.part.app')
@section('title')
    @lang('deals')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('deals')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('deals.index') }}">@lang('deals')</a>
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
                                    <h4 class="card-title">@lang('deals')</h4>
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
                                                <label for="s_title">@lang('deals')</label>
                                                <input id="s_title" type="text" class="search_input form-control"
                                                    placeholder="@lang('deals')">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_name">@lang('users')</label>
                                                <input id="s_name" type="text" class="search_input form-control"
                                                       placeholder="@lang('users')">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_type">@lang('Discount Store Type')</label>
                                                <select id="s_type" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('Discount Store Type')</option>
                                                    @foreach ($type as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
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
                                            <th>@lang('image')</th>
                                            <th>@lang('Discount Store Type')</th>
                                            <th>@lang('users')</th>
                                            <th>@lang('deals')</th>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title add</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('deals.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @foreach (locales() as $key => $value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deals_{{ $key }}">@lang('deals') @lang($value)</label>
                                    <input type="text" class="form-control"
                                        placeholder="@lang('deals') @lang($value)" name="deals_{{ $key }}"
                                        id="deals_{{ $key }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">@lang('users')</label>
                                <select class="form-control" id="" name="user_id" required>
                                    <option value="">@lang('select')</option>
                                    @foreach ($user as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->phone }} {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="image">@lang('image')</label>
                                <input type="file" accept="image/*" class="form-control"
                                    placeholder="@lang('image')" name="image" id="image">
                                <div class="invalid-feedback"></div>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('deals.update') }}" method="POST" id="form_edit" class=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" class="form-control" />
                    <div class="modal-body">
                        @foreach (locales() as $key => $value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deals_{{ $key }}">@lang('deals') @lang($value)</label>
                                    <input type="text" class="form-control"
                                        placeholder="@lang('deals') @lang($value)"
                                        name="deals_{{ $key }}" id="edit_name_{{ $key }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">@lang('users')</label>
                                <select class="form-control" id="edit_user_id" name="user_id" required>
                                    <option value="">@lang('select')</option>
                                    @foreach ($user as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->phone }} {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="image">@lang('image')</label>
                                <input type="file" accept="image/*" class="form-control"
                                    placeholder="@lang('image')" name="image" id="image">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
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
                url: '{{ route('deals.getData', app()->getLocale()) }}',
                data: function(d) {
                    d.deals = $('#s_title').val();
                    d.user_id = $('#s_name').val();
                    d.type_id = $('#s_type').val();
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
                    "data": 'image',
                    "name": 'image',
                    render: function(data, type, full, meta) {
                        return `<img src="{{ asset('uploads/${data}') }}" width="100" class="img-fluid img-thumbnail">`;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_type_name',
                    name: 'user_type_name',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'user_name',
                    name: 'user_name',
                    searchable: true,
                    orderable: true,
                },
                {
                    data: 'text_name',
                    name: 'deals',
                    searchable: true,
                    orderable: true,
                },


                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,

                },
            ]

        });


        $(document).ready(function() {
            $(document).on('click', '.btn_edit', function(event) {
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this)
                var uuid = button.data('uuid')
                $('#uuid').val(uuid);
                $('#edit_user_id').val(button.data('user_id')).trigger('change');
                $('#edit_type_id').val(button.data('type_id')).trigger('change');

                @foreach (locales() as $key => $value)
                    $('#edit_name_{{ $key }}').val(button.data('deals_{{ $key }}'))
                @endforeach

            });
        });
    </script>
@endsection
