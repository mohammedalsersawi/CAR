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
                    <div class="page-title">
                        <h4 class="mb-0 font-size-18">Responsive Table</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Agroxa</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Responsive Table</li>
                        </ol>
                    </div>

                    <div class="state-information d-none d-sm-block">
                        <div class="state-graph">
                            <div id="header-chart-1"></div>
                            <div class="info">Balance $ 2,317</div>
                        </div>
                        <div class="state-graph">
                            <div id="header-chart-2"></div>
                            <div class="info">Item Sold 1230</div>

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
                            <form action="{{route('role.store')}}" method="post"  >
                               @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Name Category</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <fieldset>
                                    <legend>Abilities</legend>
                                    @foreach (config('ability') as $ability_code => $ability_name)
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                {{ $ability_name }}
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $ability_code }}]" value="1" >
                                                Allow
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $ability_code }}]" value="0" ) checked>
                                                Deny
                                            </div>
                                        </div>
                                    @endforeach
                                </fieldset>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

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
