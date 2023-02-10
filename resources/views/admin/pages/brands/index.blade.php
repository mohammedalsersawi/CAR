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
                        <h2 class="content-header-title float-left mb-0">@lang('pages')</h2>
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
                                                        data-target="#create_modal"><span><i class="fa fa-plus"></i>Add</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive card-datatable">
                                <div id="alreat" >

                                </div>
                                <table class="table" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>@lang('#')</th>
                                        <th>@lang('title')</th>
                                        <th>@lang('image')</th>
                                        <th style="width: 225px;">@lang('actions')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-brand">
                                    @include('admin.pages.brands.inclode',['brand' => $brand])

                                    </tbody>
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
                <form id="form_add" data-action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">@lang('Name')
                                :</label>
                            <input   id="name" type="text" name="name" class="form-control">
                        </div>
                        <div class="col">
                            <label for="Name_en" class="mr-sm-2">@lang('Name English')
                                :</label>
                            <input  type="text" class="form-control" id="name-en" name="name_en">
                        </div>
                        <label for="name">@lang('image')</label>
                        <input type="file" class="form-control"
                               placeholder="enter name" name="image"
                        >

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
            $('#form_add').on('submit', function(event){
                event.preventDefault();
                var url = $('#form_add').attr('data-action');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(res)
                    {

                            $("#create_modal").modal('hide');
                            $('#table-brand').html(res);
                            $('#alreat').text('Adddd succesfully').addClass('alert alert-success');
                            $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                                $(".alert").slideUp(500);
                            });
                    },
                    error: function(response) {

                        $("#create_modal").modal('hide');
                        $('#table-brand').html(response);
                        $('#alreat').text('Add succesfully').addClass('alert alert-success');
                        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
                            $(".alert").slideUp(500);
                        });
                    }
                });
            });
            function deletebrand(id) {
                var url = $('#form_delete').attr('data-action');
                $.ajax({
                    type: 'delete',
                    url: url,
                    data: {
                        _token: '{{csrf_token()}}',
                        id:id
                    },
                    success: function (res) {
                        $("#delete"+id).modal('hide');
                        $('#row'+id).remove();
                        $('#alreat').text('Deleted succesfully').addClass('alert alert-success');
                    },
                    error: function (error) {
                        $('#alreat').text('Deleted Fail').addClass('alert alert-danger');
                    }
                });
            }
           </script>
@endsection
@section('scripts')
@endsection
