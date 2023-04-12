@extends('part.app')
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
                        <h2 class="content-header-title float-left mb-0">@lang('update') @lang('roles')</h2>
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
                            <form action="{{route('role.update',$role->uuid)}}" method="post">
                                @method('put')
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">@lang("name")</label>
                                    <input value="{{$role->name}}" type="text" name="name" class="form-control">
                                </div>
                                <fieldset>
                                    <legend>Abilities</legend>
                                    @foreach (config('ability') as $ability_code => $ability_name)
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                {{ $ability_name }}
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $ability_code }}]"
                                                       value="1" @checked(($role_abilities[$ability_code] ?? '') == 1)>
                                                Allow
                                            </div>
                                            <div class="col-md-2">
                                                <input type="radio" name="abilities[{{ $ability_code }}]"
                                                       value="0" @checked(($role_abilities[$ability_code] ?? '') == 0)>
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
