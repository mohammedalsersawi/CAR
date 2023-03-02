@extends('admin.part.app')
@section('title')
    @lang('user_order')
@endsection
@section('styles')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0"> @lang('user_order')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">@lang('user_order')</a>
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
                                    <h4 class="card-title">########</h4>
                                </div>

                            </div>

                            <div class="table-responsive card-datatable" style="padding: 20px">
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <div class="col">
                                        <div class="card">
                                            <img src="https://mdbcdn.b-cdn.net/img/new/standard/city/041.webp"
                                                class="card-img-top" alt="Hollywood Sign on The Hill" />
                                            <div class="card-body">
                                                <button class="btn btn-outline-danger">
                                                    <span>حذف</span>
                                                </button>
                                                <button class="btn btn-outline-success">
                                                    <span>تعديل</span>
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
