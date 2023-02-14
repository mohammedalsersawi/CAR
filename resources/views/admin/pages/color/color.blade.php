@extends('admin.part.app')
@section('title')
    @lang('Color Cars')
@endsection
@section('styles')
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
                                                    data-target="#full-modal-stem"><span><i class="fa fa-plus"></i>@lang('add')</span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive card-datatable">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('colors')</th>
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
    @include('admin.pages.color.modal')
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
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'name.{{app()->currentLocale()}}',
                        name: 'name'
                    },
                    {
                        data: 'color',
                        "render": function (data, type, full, meta) {
                            return  "<div style='background-color:" + data + ";width: 50px;height: 50px'></div>";
                        },


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
             $(document).on('click', '.edit_btn', function(event) {
                 event.preventDefault();
                 var button = $(this)
                 var id = button.data('id');
                 var color = button.data('color');
                 $('#id').val(id);
                 $('#color').val(color);
                 @foreach (locales() as $key => $value)
                 $('#edit_name_{{ $key }}').val(button.data('name_{{ $key }}'))
                 @endforeach

             });
         });

    </script>


@endsection
