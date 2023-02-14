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
                                                    data-target="#create_modal"><span><i class="fa fa-plus"></i>@lang('add')</span>
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

    <!-- Modal -->
    <div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="add_model_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="id" class="form-control" />
                    <div class="modal-body">
                        @foreach (locales() as $key => $value)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name_{{ $key }}">@lang('name') @lang($value)</label>
                                    <input type="text" class="form-control"
                                        placeholder="@lang('name') @lang($value)" name="name_{{ $key }}"
                                        id="name_{{ $key }}">
                                    <small class="text-danger last_name_error" id="name_{{ $key }}_error"></small>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <div>
                                <span class="btn btn-info btn-file ">
                                    <span class="fileinput-new"> @lang('select_image')</span>
                                    <span class="fileinput-exists"> @lang('select_image')</span>
                                    <input type="file" name="image"></span>
                                <small class="text-danger last_name_error" id="image_error"></small>
                            </div>
                            <div class="invalid-feedback"></div>
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

        //add
        $('#add_model_form').on('submit', function(event) {
            event.preventDefault();
            var data = new FormData(this);
            var url = "{{ route('brand.store') }}";
            $('input').removeClass('is-invalid');
            $('.text-danger').text('');
            $('.btn-file').addClass('');
            $.ajax({
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                url,
                data,
                success: function(result) {
                    $('#create_modal').modal('hide');
                    $("#add_model_form").trigger("reset");
                    table.draw()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.each(jqXHR.responseJSON.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                        $('input[name=' + key + ']').addClass('is-invalid');
                        $('.btn-file').addClass('btn btn-danger');

                    });
                }
            });
        });

        //Update
        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $('#create_modal .modal-title').text('Update');
            $.ajax({
                url: "{{ route('brand.edit') }}" + '/' + id,
                method: 'get',
                beforeSend: function() {},
                success: function(data) {
                    console.log(data);
                    $.each(data.data.name, function(key, val) {
                        $('#add_model_form [name=name_' + key + ']').val(val)
                    });

                    $('#add_model_form [name="id"]').val(data.data.id)
                    $('#create_modal').modal('show');
                    table.draw()
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        });

        $(document).on('click', '.btn_delete', function(e) {
            e.preventDefault();
            let deleted_id = $(this).data('id');
            Swal.fire({
                text: 'هل تريد استمرار علمية الحذف ؟',
                confirmButtonClass: 'btn btn-success btn-sm ',
                cancelButtonClass: 'btn btn-danger  btn-sm',
                confirmButtonText:"@lang('sure')",
                cancelButtonText: "@lang('close')",
                buttonsStyling: false,
                showCancelButton: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('brand.delete') }}" + '/' + deleted_id,
                        type: 'delete',
                        beforeSend: function() {},
                        success: function(data) {
                            table.draw()
                        },
                        error: function() {}
                    });
                }
            })
        });

        $('#create_modal').on('hidden.bs.modal', function(e) {
            $('#create_modal .modal-title').text(@lang('add'));
        })
    </script>
@endsection
