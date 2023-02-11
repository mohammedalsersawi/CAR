@extends('admin.part.app')
@section('title')
    @lang('pages')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">brands</h2>
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
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_title">@lang('title')</label>
                                                <input id="s_title" type="text" class="search_input form-control"
                                                    placeholder="@lang('title')">
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
                                        <div class="col-3" style="margin-top: 20px">
                                            <div class="form-group">
                                                <button class="btn btn-outline-primary" type="button" data-toggle="modal"
                                                    data-target="#create_modal"><span><i class="fa fa-plus"></i>اضافة</span>
                                                </button>
                                                <a class="btn btn-success btn_edit btn-sm " data-id="1"
                                                    data-toggle="tooltip" title="تعديل">
                                                    <span class="fa fa-edit">تعديل</span>
                                                </a>
                                                <a class="btn btn-danger btn_delete  btn-sm  " data-id="7"
                                                    data-toggle="tooltip" title="حذف">
                                                    <span class="fa fa fa-times">حذف</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive card-datatable">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>name_en</th>
                                            <th>name_ar</th>
                                            <th style="width: 225px;">actin</th>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
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
                            <label for="icon">@lang('icon')</label>
                            <div class="form-group">
                                <div class="fileinput fileinput-exists" data-provides="fileinput">
                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput"
                                        style="width: 200px; height: 150px;">
                                        <img id="edit_src_image" src="" alt="" />
                                    </div>
                                    <div>
                                        <span class="btn btn-secondary btn-file  ">
                                            <span class="fileinput-new"> @lang('select_image')</span>
                                            <span class="fileinput-exists"> @lang('select_image')</span>
                                            <input type="file" name="image"></span>
                                        <small class="text-danger last_image_error" id="image_error"></small>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
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
        //add
        $('#add_model_form').on('submit', function(event) {
            event.preventDefault();
            var data = new FormData(this);
            var url = "{{ route('brand.store') }}";
            $('input').removeClass('is-invalid');
            $('.text-danger').text('');
            $('.btn-file').addClass('btn btn-secondary');
            $('.btn-file').removeClass('btn btn-outline-danger');
            $('#edit_src_image').attr('src', '');
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
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $.each(jqXHR.responseJSON.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                        $('input[name=' + key + ']').addClass('is-invalid');
                    });
                    $('.btn-file').removeClass('btn btn-secondary');
                    $('.btn-file').addClass('btn btn-outline-danger');

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
                    $.each(data.data.name, function(key, val) {
                        $('#add_model_form [name=name_' + key + ']').val(val)
                    });
                    var source = '{!! asset("uploads/'+data.data.avatar.full_small_path+'") !!}';
                    $('#edit_src_image').attr('src', source);
                    $('#add_model_form [name="id"]').val(data.data.id)
                    $('#create_modal').modal('show');
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
                confirmButtonText: "تأكيد",
                cancelButtonText: " إلغاء",
                buttonsStyling: false,
                showCancelButton: true
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('brand.delete') }}" + '/' + deleted_id,
                        type: 'delete',
                        beforeSend: function() {},
                        success: function(data) {},
                        error: function() {}
                    });
                }
            })
        });
    </script>

    <script type="text/javascript">
        $(function() {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('model') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name.en'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endsection
