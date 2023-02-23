@extends('admin.part.app')
@section('title')
    @lang('city Cars')
@endsection
@section('styles')
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
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ url('/admin/pages') }}">@lang('pages')</a>
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
                                    <h4 class="card-title">@lang('pages')</h4>
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


                                        <div class="col-3" style="margin-top: 20px">
                                            <div class="form-group">

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
                                            <th>@lang('area')</th>
                                            <th>@lang('cities')</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('area.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @foreach (locales() as $key => $value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name_{{ $key }}">@lang('name') @lang($value)</label>
                                    <input type="text" class="form-control"
                                        placeholder="@lang('name') @lang($value)" name="name_{{ $key }}"
                                        id="name_{{ $key }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">@lang('city')</label>
                                <select name="city_id" id="" class="select form-control"
                                    data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('area')</option>
                                    @foreach ($cities as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        </option>
                                    @endforeach
                                </select>
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
                <form action="{{ route('area.update') }}" method="POST" id="form_edit" class=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="modal-body">
                        @foreach (locales() as $key => $value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name_{{ $key }}">@lang('name') @lang($value)</label>
                                    <input type="text" class="form-control"
                                        placeholder="@lang('name') @lang($value)"
                                        name="name_{{ $key }}" id="edit_name_{{ $key }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div class="form-group">
                                <label for="city_id">@lang('cities')</label>
                                <select class="form-control" id="edit_city_id" name="city_id" required>
                                    <option value="">@lang('select') @lang('area')</option>
                                    @foreach ($cities as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
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
                url: '{{ route('area.getData', app()->getLocale()) }}',
                data: function(d) {
                    d.name = $('#s_name').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name_text',
                    name: 'name'
                },
                {
                    data: 'name_city',
                    name: 'cities'
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
                var id = button.data('id');
                $('#edit_city_id').val(button.data('city_id')).trigger('change');
                $('#id').val(id);
                @foreach (locales() as $key => $value)
                    $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                @endforeach

            });
        });
    </script>
@endsection
