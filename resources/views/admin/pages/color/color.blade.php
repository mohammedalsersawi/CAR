@extends('admin.part.app')
@section('title')
    @lang('Color Cars')
@endsection
@section('styles')
    <style>
        input[type="checkbox"] {
            transform: scale(1.5);
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> @lang('Color Cars')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('color.index') }}">@lang('Color Cars')</a>
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
                                    <h4 class="card-title">@lang('Color Cars')</h4>
                                </div>
                                <div class="text-right">
                                    <div class="form-group">
                                        <button class="btn btn-outline-primary button_modal" type="button"
                                            data-toggle="modal" data-target="#full-modal-stem"><span><i
                                                    class="fa fa-plus"></i>@lang('add')</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form id="search_form">
                                    <div class="row">
                                        <div class="col-3" style="margin-top: 20px">
                                            <button id="btn_delete_all"
                                                    class="btn_delete_all btn btn-outline-danger " type="button">
                                                <span><i class="fa fa-lg fa-trash-alt" aria-hidden="true"></i> @lang('delete')</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive card-datatable" style="padding: 20px">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                            <th>@lang('name')</th>
                                            <th>@lang('colors')</th>
                                            <th>@lang('status')</th>
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
    <div class="modal fade" id="full-modal-stem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('color.store') }}" method="POST" id="add_model_form" class="add-mode-form">
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
                                <label for="color">@lang('color')</label>
                                <input type="color" class="form-control" placeholder="@lang('color')" name="color"
                                    id="color">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button type="submit" class="btn btn-primary">@lang('add')</button>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('edit')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('color.update') }}" method="POST" id="form_edit" class=""
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="uuid" id="uuid" class="form-control" />
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
                                <label for="color">@lang('color')</label>
                                <input type="color" class="form-control colors-list" placeholder="@lang('color')"
                                    name="color">
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
@section('js')
@endsection
@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/25.0.0/classic/ckeditor.js"></script>
    <script type="text/javascript">
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('color.getData') }}",
            columns: [
                {
                    "render": function (data, type, full, meta) {
                        return `<td><input type="checkbox" value="${data}" class="box1" ></td>
`;
                    },
                    name: 'checkbox',
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name_text',
                    name: 'name'
                },
                {
                    data: 'color',
                    "render": function(data, type, full, meta) {
                        return "<div style='background-color:" + data + ";width: 50px;height: 50px'></div>";
                    },
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //add
        //Update
        $(document).ready(function() {
            $('#color').val();
            $(document).on('click', '.edit_btn', function(event) {
                event.preventDefault();
                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                var button = $(this)
                var uuid = button.data('uuid');
                var color = button.data('color');
                $('#uuid').val(uuid);
                $('.colors-list').val(color);
                console.log(color);
                @foreach (locales() as $key => $value)
                    $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                @endforeach

            });
        });
    </script>
@endsection
