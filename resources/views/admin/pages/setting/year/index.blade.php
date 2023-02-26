@extends('admin.part.app')
@section('title')
    @lang('year')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('year')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">@lang('settings')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('setting.year') }}">@lang('year')</a>
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
                                    <h4 class="card-title">@lang('year')</h4>
                                </div>
                                <div class="text-right">
                                    <div class="form-group">

                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('setting.year') }}" method="POST"  id="add_model_form" class="add-mode-form">
                                   @csrf
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="from">@lang('from')</label>
                                                <input  type="text" name="from" class="form-control"
                                                       placeholder="@lang('year')">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="to">@lang('to')</label>
                                                <input type="text" name="to" class=" form-control"
                                                       placeholder="@lang('year')" >
                                            </div>
                                        </div>

                                        <div class="col-3" style="margin-top: 20px">
                                            <button class="btn btn-outline-primary button_modal" type="submit" ><span><i
                                                        class="fa fa-plus"></i>@lang('add')</span>
                                            </button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <!-- Modal -->
@endsection
@section('js')
@endsection

