@extends('admin.part.app')
@section('title')
    @lang('Brand Cars')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('Brand Cars')</h2>
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

                                </div>
                            </div>
                            <div class="card-body">
                                <form id="search_form">
                                    <div class="row">


                                        <div class="col-3" style="margin-top: 20px">
                                            <div class="form-group">
                                                <button class="btn btn-outline-primary" type="button" data-toggle="modal"
                                                    data-target="#full-modal-stem"><span><i
                                                            class="fa fa-plus"></i>اضافة</span>
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
                                            <th>@lang('name')</th>
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



    @include('admin.pages.brand.modal')
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
                url: '{{ url(app()->getLocale() . '/brand/getData') }}',
                data: function(d) {
                    d.name = $('#s_name').val();
                    console.log(d);
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                {
                    "data": 'image',
                    "name": 'image',
                    render: function(data, type, full, meta) {
                        return `<img src="{{ asset('uploads/${data}') }}" width="100" class="img-fluid img-thumbnail">`;
                    },
                },
                {
                    data: 'name_text',
                    name: 'name'
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
                event.preventDefault();
                var button = $(this)
                var id = button.data('id')
                $('#id').val(id);
                @foreach (locales() as $key => $value)
                    $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                @endforeach
                $('#form_edit').on('submit', function(event) {
                    event.preventDefault();
                    var data = new FormData(this);
                    let url = $(this).attr('action');
                    let method = $(this).attr('method');
                    $.ajax({
                        type: method,
                        cache: false,
                        contentType: false,
                        processData: false,
                        url: url,
                        data: data,
                        beforeSend: function() {
                            $('input').removeClass('is-invalid');
                            $('.text-danger').text('');
                            $('.btn-file').addClass('');
                        },
                        success: function(result) {
                            $('#edit_modal').modal('hide');
                            $('.form_edit').trigger("reset");
                            toastr.success('@lang('done_successfully')', '', {
                                rtl: isRtl
                            });
                            table.draw()
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $.each(jqXHR.responseJSON.errors, function(key, val) {
                                $("#" + key + "_error").text(val[0]);
                                $('input[name=' + key + ']').addClass(
                                    'is-invalid');
                                $('input[name=' + key + ']').addClass(
                                    'is-invalid');
                            });

                        }
                    });
                })
            });
        });
    </script>
@endsection
