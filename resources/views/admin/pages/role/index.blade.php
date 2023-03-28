@extends('admin.part.app')
@section('title')
    @lang('roles')
@endsection
@section('styles')
    <style>
        input[type="checkbox"] {
            transform: scale(1.5);
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('roles')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">@lang('roles')</a>
                                </li>
                            </ol>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Start Page-content-Wrapper -->
        <div class="page-content-wrapper">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="m-0"></h3>
                                @can('role.create')

                                <a href="{{route('role.create')}}">  <button class="btn btn-success waves-effect waves-light">@lang('add')</button></a>
                                @endcan
                            </div>

                            <br><br>
                            <div class="table-rep-plugin">

                                <div class="table- mb-0" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="3">@lang('name')</th>
                                            <th data-priority="3">@lang('actions')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($role as $item)
                                            <tr>
                                                <th data-priority="1">{{$loop->index+1}}</th>
                                                <th data-priority="3">{{$item->name}}</th>
                                                <td>
                                                    <div class="">
                                                        <div class="btn-group me-1 mt-2">


                                                                @can('role.update')
                                                                <a class="dropdown-item" href="{{route('role.edit',$item->uuid)}}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>@lang('edit')</span>
                                                                </a>
                                                                @endcan
                                                                @can('role.delete')
                                                                <button class="dropdown-item btn_delete" data-bs-toggle="modal"
                                                                        data-id="{{$item->uuid}}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>@lang('delete')</span>
                                                                </button>
                                                                @endcan

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>


                                            <!-- Modal -->
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->

        </div>
        <!-- End Page-content-wrapper -->

    </div>





@endsection
