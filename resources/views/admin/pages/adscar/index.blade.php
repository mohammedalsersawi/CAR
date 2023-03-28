@extends('admin.part.app')
@section('tilte')
    @lang('Car ads')
@endsection
@section('styles')
    <style>
        #map {
            height: 300px;
        }
    </style>
    <style>
        #map2 {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('Car ads')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('ads.car.index') }}">@lang('Car ads')</a>
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
                                    <h4 class="card-title">@lang('Car ads')</h4>
                                </div>
                                @can('ads.create')
                                <div class="text-right">
                                    <div class="form-gruop">
                                        <button class="btn btn-outline-primary button_modal" type="button"
                                                data-toggle="modal" id="addd" data-target="#full-modal-stem"><span><i
                                                    class="fa fa-plus"></i>@lang('add')</span>
                                        </button>

                                    </div>
                                </div>
                                @endcan
                            </div>


                            <div class="card-body">
                                <form id="search_form">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_mobile">@lang('phone')</label>
                                                <input id="s_phone" type="text" class="search_input form-control"
                                                       placeholder="@lang('phone')">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="s_price">@lang('price')</label>
                                                <input id="s_price" type="text" class="search_input form-control"
                                                       placeholder="@lang('price')">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="s_showroom_uuid">@lang('users')</label>
                                                <select  id="s_showroom_uuid" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('users')</option>
                                                    @foreach ($User as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="mileage">@lang('mileage')</label>
                                                <input type="text" class="search_input form-control"
                                                       placeholder="@lang('mileage')" name="mileage" id="s_mileage">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="year_to">@lang('year')</label>
                                                <select name="year" id="s_year" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('year')</option>
                                                    @isset($year)
                                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                                    @endisset

                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('brand')</label>
                                                <select name="brand_uuid" id="s_brand" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('brand')</option>
                                                    @foreach ($Brand as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('Model')</label>
                                                <select name="model_uuid" id="s_model" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('Model')</option>
                                                    @foreach ($ModelCar as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('Engine')</label>
                                                <select name="engine_uuid" id="s_engine" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('Engine')</option>
                                                    @foreach ($Engine as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>


                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('Transmission')</label>
                                                <select name="transmission_uuid" id="s_transmission"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('Transmission')</option>
                                                    @foreach ($Transmission as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                        </option>

                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('color_interior')</label>
                                                <select name="color_interior_uuid" id="s_color_interior"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('color_interior')</option>
                                                    @foreach ($ColorCar as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                            <div
                                                                style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                            </div>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('color_exterior')</label>
                                                <select name="color_exterior_uuid" id="s_color_exterior"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('color_exterior')</option>
                                                    @foreach ($ColorCar as $itemm)
                                                        <option value="{{ $itemm->uuid }}">
                                                            <h1>{{ $itemm->name }} </h1>
                                                        </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('fueltype')</label>
                                                <select name="fule_type_uuid" id="s_fuel"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>@lang('select') @lang('fueltype')</option>
                                                    @foreach ($FuelType as $itemm)
                                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
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
                                                <button id="btn_delete_all"
                                                        class="btn_delete_all btn btn-outline-danger " type="button">
                                                    <span><i class="fa fa-lg fa-trash-alt" aria-hidden="true"></i> @lang('delete')</span>
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
                                        <th><input name="select_all" id="example-select-all" type="checkbox" onclick="CheckAll('box1', this)" /></th>
                                        <th>@lang('phone')</th>
                                        <th>@lang('users')</th>
                                        <th>@lang('price')</th>
                                        <th>@lang('year')</th>
                                        <th>@lang('mileage')</th>
                                        <th>@lang('Brand')</th>
                                        <th>@lang('Model')</th>
                                        <th>@lang('Engine')</th>
                                        <th>@lang('fueltype')</th>
                                        <th>@lang('color_exterior')</th>
                                        <th>@lang('color_interior')</th>
                                        <th>@lang('Transmission')</th>
                                        @can('ads.delete'||'ads.update')
                                        <th style="width: 225px;">@lang('actions')</th>
                                        @endcan
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
    <div class="modal fade" class="full-modal-stem" id="full-modal-stem" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ads.car.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('users')</label>
                                <select name="showroom_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('users')</option>
                                    @foreach ($User as $itemm)
                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} {{ $itemm->phone }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                          </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">@lang('phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('phone')"
                                           name="phone" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">@lang('price')</label>
                                    <input type="text" class="form-control" placeholder="@lang('price')"
                                           name="price" id="price">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                                <label for="">@lang('brand')</label>
                                <select name="brand_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('brand')</option>
                                    @foreach ($Brand as $itemm)
                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('Model')</label>
                                <select name="model_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('Model')</option>
                                    @foreach ($ModelCar as $itemm)
                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_interior')</label>
                                    <select name="color_interior_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_interior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                <div
                                                    style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                </div>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_exterior')</label>
                                    <select name="color_exterior_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_exterior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}">
                                                <h1>{{ $itemm->name }} </h1>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage">@lang('mileage')</label>
                                    <input type="text" class="form-control" placeholder="@lang('mileage')"
                                           name="mileage" id="mileage">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Engine')</label>
                                    <select name="engine_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Engine')</option>
                                        @foreach ($Engine as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="year_to">@lang('year')</label>
                                <select name="year" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('select')</option>
                                    @isset($year)
                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                    @endisset

                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('Transmission')</label>
                                <select name="transmission_uuid" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('Transmission')</option>
                                    @foreach ($Transmission as $itemm)
                                        <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                    </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('fueltype')</label>
                                    <select name="fule_type_uuid" id="" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('fueltype')</option>
                                        @foreach ($FuelType as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">@lang('image')</label>
                                    <input type="file" accept="image/*" class="form-control"
                                           placeholder="@lang('image')" name="image[]" multiple id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                        <div class="text-right mb-2">
                            <button class="add_row btn btn-sm btn-dark">@lang('add row')</button>
                        </div>
                        <div class="row_data">
                            <div class="row mb-12">
                                <div class="col-md-11">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input name="specification[]" type="text" class="form-control">
                                        </div>
                                        <div class="col-md-1">
                                            <button class="btn btn-danger  remove_row">@lang('delete')</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <div id="map"></div>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button class="btn btn-primary">@lang('add')</button>
                    </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">@lang('edit')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ads.car.update') }}" method="POST" id="form_edit" class="form_edit"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('users')</label>
                                    <select name="showroom_uuid" id="edit_user" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('users')</option>
                                        @foreach ($User as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} {{ $itemm->phone }}</option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">@lang('phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('phone')"
                                           name="phone" id="edit_phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">@lang('price')</label>
                                    <input type="text" class="form-control" placeholder="@lang('price')"
                                           name="price" id="edit_price">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('brand')</label>
                                    <select name="brand_uuid" id="edit_brand" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                            aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('brand')</option>
                                        @foreach ($Brand as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Model')</label>
                                    <select name="model_uuid" id="edit_model" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                            aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Model')</option>
                                        {{--                                    @foreach ($ModelCar as $itemm) --}}
                                        {{--                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option> --}}
                                        {{--                                        </option> --}}
                                        {{--                                    @endforeach --}}
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_interior')</label>
                                    <select name="color_interior_uuid" id="edit_color_exterior"
                                            class="select form-control" data-select2-id="select2-data-1-bgy2"
                                            tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_interior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }}
                                                <div
                                                    style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                </div>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('color_exterior')</label>
                                    <select name="color_exterior_uuid" id="edit_color_interior"
                                            class="select form-control" data-select2-id="select2-data-1-bgy2"
                                            tabindex="-1" aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('color_exterior')</option>
                                        @foreach ($ColorCar as $itemm)
                                            <option value="{{ $itemm->uuid }}">
                                                <h1>{{ $itemm->name }} </h1>
                                            </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage">@lang('mileage')</label>
                                    <input type="text" class="form-control" placeholder="@lang('mileage')"
                                           name="mileage" id="edit_mileage">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">@lang('Engine')</label>
                                    <select name="engine_uuid" id="edit_engine" class="select form-control"
                                            data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                            aria-hidden="true">
                                        <option selected disabled>@lang('select') @lang('Engine')</option>
                                        @foreach ($Engine as $itemm)
                                            <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <div class="form-group">
                                <label for="year_to">@lang('year')</label>
                                <select name="year" id="edit_year" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>@lang('select') @lang('year')</option>
                                    @isset($year)
                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                    @endisset

                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                          </div>
                           <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">@lang('Transmission')</label>
                                        <select name="transmission_uuid" id="edit_transmission"
                                                class="select form-control" data-select2-id="select2-data-1-bgy2"
                                                tabindex="-1" aria-hidden="true">
                                            <option selected disabled>@lang('select') @lang('Transmission')</option>
                                            @foreach ($Transmission as $itemm)
                                                <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                        </div>
                                <div class="row">


                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('fueltype')</label>
                                            <select name="fule_type_uuid" id="edit_fuel" class="select form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected disabled>@lang('select') @lang('fueltype')</option>
                                                @foreach ($FuelType as $itemm)
                                                    <option value="{{ $itemm->uuid }}"> {{ $itemm->name }} </option>

                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">@lang('image')</label>
                                            <input type="file" multiple accept="image/*" class="form-control"
                                                   placeholder="@lang('image')" name="image[]" id="image">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="map2"></div>
                                <input type="hidden" name="lat" id="edit_lat">
                                <input type="hidden" name="lng" id="edit_lng">

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
@section('scripts')
    <script>
        var map2 = L.map('map2').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map2);

        var lon;
        var lat;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";

        }

        function showPosition(position) {

            function onMapClick(e) {
                $('#edit_lat').val(e.latlng.lat)
                $('#edit_lng').val(e.latlng.lng)
                console.log(e);
                var layar = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map2)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();

            }

            map2.on('click', onMapClick);
        }
    </script>
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
            searching: false,
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
                url: '{{ route('ads.car.getData', app()->getLocale()) }}',
                data: function (d) {
                    d.phone = $('#s_phone').val();
                    d.mileage = $('#s_mileage').val();
                    d.year = $('#s_year').val();
                    d.showroom_uuid = $('#s_showroom_uuid').val();
                    d.brand = $('#s_brand').val();
                    d.model = $('#s_model').val();
                    d.engine = $('#s_engine').val();
                    d.fueltype = $('#s_fuel').val();
                    d.price = $('#s_price').val();
                    d.transmission = $('#s_transmission').val();
                    d.color_exterior = $('#s_color_exterior').val();
                    d.color_interior = $('#s_color_interior').val();

                }
            },
            columns: [
                {
                    "render": function (data, type, full, meta) {
                        return `<td><input type="checkbox" onclick="checkClickFunc()" value="${data}" class="box1" ></td>
`;
                    },
                    name: 'checkbox',
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'mileage',
                    name: 'mileage'
                },
                {
                    data: 'brand_name',
                    name: 'brand',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'model_name',
                    name: 'model',
                    orderable: false,
                    searchable: false
                },

                {
                    data: 'engine_name',
                    name: 'engine',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'fueltype_name',
                    name: 'fueltype',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'color_exterior_car',
                    "render": function (data, type, full, meta) {
                        return "<div style='background-color:" + data + ";width: 20px;height: 20px'></div>";
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'color_interior_car',
                    "render": function (data, type, full, meta) {
                        return "<div style='background-color:" + data + ";width: 20px;height: 20px'></div>";
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'transmission_name',
                    name: 'transmission'
                },
                    @can('ads.delete'||'ads.update')
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
                @endcan
            ]

        });


        $(document).ready(function () {
            $(document).on('click', '.btn_edit', function (event) {

                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                $('#edit_model').val(button.data('model_uuid')).trigger('change');
                $('#edit_transmission').val(button.data('transmission_uuid')).trigger('change');
                $('#edit_brand').val(button.data('brand_uuid'));
                $('#edit_model').append('<option value="' + button.data('model_uuid') + '" selected>' + button
                    .data('model_name') + '</option>');
                // $('#edit_model').val( button.data('model_uuid'));
                $('#edit_engine').val(button.data('engine_uuid')).trigger('change');
                $('#edit_fuel').val(button.data('fule_type_uuid')).trigger('change');

                $('#edit_color_exterior').val(button.data('color_exterior_uuid'));
                $('#edit_color_interior').val(button.data('color_interior_uuid'));
                $('#edit_lat').val(button.data('lat'))
                $('#edit_year').val(button.data('year')).trigger('change')
                $('#edit_lng').val(button.data('lng'))
                $('#edit_price').val(button.data('price'))
                $('#edit_user').val(button.data('user')).trigger('change')

                $('#edit_mileage').val(button.data('mileage'))
                $('#edit_phone').val(button.data('phone'))
                $('#uuid').val(uuid);

                L.marker([button.data('lat'), button.data('lng')]).addTo(map2)
                    .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
                    .openPopup();

            });
            $(document).on('click', '#addd', function () {
                // map.eachLayer(function (layer) {
                //     map.removeLayer(layer);
                // });
            });
        });
        $('#edit_modal').on('hidden.bs.modal', function () {
            $('select[name="model_uuid"]').empty();
            // $('.search_input').val("").trigger("change")

        })
    </script>
    <script>
        $(document).ready(function () {
            $('select[name="brand_uuid"]').on('change', function () {
                var brand_uuid = $(this).val();
                if (brand_uuid) {
                    $.ajax({
                        url: "car/model" + "/" + brand_uuid,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="model_uuid"]').empty();
                            $('select[name="model_uuid"]').append(`
                                 <option selected  disabled>@lang('select') @lang('Model')</option>
                                 `)
                            $.each(data, function (key, value) {
                                $('select[name="model_uuid"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var lon;
        var lat;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";

        }

        //
        function showPosition(position) {


            function onMapClick(e) {
                $('#lat').val(e.latlng.lat)
                $('#lng').val(e.latlng.lng)
                console.log(e);
                // map.eachLayer(function (layer) {
                //     map.removeLayer(layer);
                // });
                L.marker([e.latlng.lat, e.latlng.lng]).addTo(map)
                    .openPopup();

            }

            map.on('click', onMapClick);


        }
    </script>
    <script
    >
        $(".alert").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert").slideUp(500);
        });
        $('.add_row').click(function(e) {
            e.preventDefault();

            const row = `
 <div class="row mb-12">
                                                <div class="col-md-11">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                                <input name="specification[]" type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button class="btn btn-danger  remove_row">@lang('delete')</button>
                                                        </div>

                                                </div>

                                            </div>
                                        </div>`;

            $('.row_data').append(row);

        })

        $('body').on('click', '.remove_row', function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        })

    </script>
@endsection
