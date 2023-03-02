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
                        <h2 class="content-header-title float-left mb-0">@lang('city')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
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
                                <div class="text-right">
                                    <div class="form-gruop">
                                        <button class="btn btn-outline-primary button_modal" type="button"
                                                data-toggle="modal" id="addd" data-target="#full-modal-stem"><span><i
                                                    class="fa fa-plus"></i>@lang('add')</span>
                                        </button>

                                    </div>
                                </div>
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
                                                    <option selected disabled>Select @lang('year')</option>
                                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('brand')</label>
                                                <select name="brand_id" id="s_brand" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('brand')</option>
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
                                                <select name="model_id" id="s_model" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('Model')</option>
                                                    @foreach ($ModelCar as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('Engine')</label>
                                                <select name="engine_id" id="s_engine" class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('Engine')</option>
                                                    @foreach ($Engine as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>


                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('Transmission')</label>
                                                <select name="transmission_id" id="s_transmission"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('Transmission')</option>
                                                    @foreach ($Transmission as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }}
                                                        </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('color_interior')</label>
                                                <select name="color_interior_id" id="s_color_interior"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('color_interior')</option>
                                                    @foreach ($ColorCar as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }}
                                                            <div
                                                                style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                            </div>
                                                        </option>
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">@lang('color_exterior')</label>
                                                <select name="color_exterior_id" id="s_color_exterior"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('color_exterior')</option>
                                                    @foreach ($ColorCar as $itemm)
                                                        <option value="{{ $itemm->id }}">
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
                                                <select name="fule_type_id" id="s_fuel"
                                                        class="search_input form-control"
                                                        data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option selected disabled>Select @lang('fueltype')</option>
                                                    @foreach ($FuelType as $itemm)
                                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }}
                                                        </option>
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

                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>


                            <div class="table-responsive card-datatable" style="padding: 20px">
                                <table class="table" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('phone')</th>
                                        {{--                                            <th>@lang('image')</th>--}}
                                        <th>@lang('year')</th>

                                        <th>@lang('mileage')</th>
                                        <th>@lang('Brand')</th>
                                        <th>@lang('Model')</th>
                                        <th>@lang('Engine')</th>
                                        <th>@lang('fueltype')</th>
                                        <th>@lang('color_exterior')</th>
                                        <th>@lang('color_interior')</th>
                                        <th>@lang('Transmission')</th>

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
                                    <label for="phone">@lang('phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('phone')"
                                           name="phone" id="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage">@lang('mileage')</label>
                                    <input type="text" class="form-control" placeholder="@lang('mileage')"
                                           name="mileage" id="mileage">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="year_to">@lang('year')</label>
                                <select name="year" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('select')</option>
                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="">@lang('brand')</label>
                                <select name="brand_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('brand')</option>
                                    @foreach ($Brand as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('Model')</label>
                                <select name="model_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('Model')</option>
                                    @foreach ($ModelCar as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
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
                                <label for="">@lang('Engine')</label>
                                <select name="engine_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('Engine')</option>
                                    @foreach ($Engine as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('Transmission')</label>
                                <select name="transmission_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('Transmission')</option>
                                    @foreach ($Transmission as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
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
                                <label for="">@lang('color_interior')</label>
                                <select name="color_interior_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('color_interior')</option>
                                    @foreach ($ColorCar as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }}
                                            <div
                                                style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                            </div>
                                        </option>
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">@lang('color_exterior')</label>
                                <select name="color_exterior_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('color_exterior')</option>
                                    @foreach ($ColorCar as $itemm)
                                        <option value="{{ $itemm->id }}">
                                            <h1>{{ $itemm->name }} </h1>
                                        </option>
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
                                <label for="">@lang('fueltype')</label>
                                <select name="fule_type_id" id="" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('fueltype')</option>
                                    @foreach ($FuelType as $itemm)
                                        <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                        </option>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
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
                                    <label for="phone">@lang('phone')</label>
                                    <input type="text" class="form-control" placeholder="@lang('phone')"
                                           name="phone" id="edit_phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mileage">@lang('mileage')</label>
                                    <input type="text" class="form-control" placeholder="@lang('mileage')"
                                           name="mileage" id="edit_mileage">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="year_to">@lang('year')</label>
                                <select name="year" id="edit_year" class="select form-control"
                                        data-select2-id="select2-data-1-bgy2" tabindex="-1" aria-hidden="true">
                                    <option selected disabled>Select @lang('year')</option>
                                    @for ($i = $year->from; $i <= $year->to ;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="invalid-feedback"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('brand')</label>
                                            <select name="brand_id" id="edit_brand" class="select form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected disabled>Select @lang('brand')</option>
                                                @foreach ($Brand as $itemm)
                                                    <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('Model')</label>
                                            <select name="model_id" id="edit_model" class="select form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected disabled>Select @lang('Model')</option>
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
                                            <label for="">@lang('Engine')</label>
                                            <select name="engine_id" id="edit_engine" class="select form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected disabled>Select @lang('Engine')</option>
                                                @foreach ($Engine as $itemm)
                                                    <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('Transmission')</label>
                                            <select name="transmission_id" id="edit_transmission"
                                                    class="select form-control" data-select2-id="select2-data-1-bgy2"
                                                    tabindex="-1" aria-hidden="true">
                                                <option selected disabled>Select @lang('Transmission')</option>
                                                @foreach ($Transmission as $itemm)
                                                    <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
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
                                            <label for="">@lang('color_interior')</label>
                                            <select name="color_interior_id" id="edit_color_exterior"
                                                    class="select form-control" data-select2-id="select2-data-1-bgy2"
                                                    tabindex="-1" aria-hidden="true">
                                                <option selected disabled>Select @lang('color_interior')</option>
                                                @foreach ($ColorCar as $itemm)
                                                    <option value="{{ $itemm->id }}"> {{ $itemm->name }}
                                                        <div
                                                            style="height:50px;width:50px;background-color:{{ $itemm->color }}">
                                                        </div>
                                                    </option>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">@lang('color_exterior')</label>
                                            <select name="color_exterior_id" id="edit_color_interior"
                                                    class="select form-control" data-select2-id="select2-data-1-bgy2"
                                                    tabindex="-1" aria-hidden="true">
                                                <option selected disabled>Select @lang('color_exterior')</option>
                                                @foreach ($ColorCar as $itemm)
                                                    <option value="{{ $itemm->id }}">
                                                        <h1>{{ $itemm->name }} </h1>
                                                    </option>
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
                                            <label for="">@lang('fueltype')</label>
                                            <select name="fule_type_id" id="edit_fuel" class="select form-control"
                                                    data-select2-id="select2-data-1-bgy2" tabindex="-1"
                                                    aria-hidden="true">
                                                <option selected disabled>Select @lang('fueltype')</option>
                                                @foreach ($FuelType as $itemm)
                                                    <option value="{{ $itemm->id }}"> {{ $itemm->name }} </option>
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">@lang('image')</label>
                                            <input type="file" multiple accept="image/*" class="form-control"
                                                   placeholder="@lang('image')" name="image" id="image">
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
                    d.brand = $('#s_brand').val();
                    d.model = $('#s_model').val();
                    d.engine = $('#s_engine').val();
                    d.fueltype = $('#s_fuel').val();
                    d.transmission = $('#s_transmission').val();
                    d.color_exterior = $('#s_color_exterior').val();
                    d.color_interior = $('#s_color_interior').val();

                }
            },
            columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
                {
                    data: 'phone',
                    name: 'phone'
                },
                    {{--{--}}
                    {{--    "data": 'image',--}}
                    {{--    "name": 'image',--}}
                    {{--    render: function(data, type, full, meta) {--}}
                    {{--        return `<img src="{{ asset('uploads/${data}') }}" width="100" class="img-fluid img-thumbnail">`;--}}
                    {{--    },--}}
                    {{--},--}}

                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'mileage',
                    name: 'mileage'
                },
                {
                    data: 'brand',
                    name: 'brand'
                },
                {
                    data: 'model',
                    name: 'model'
                },

                {
                    data: 'engine',
                    name: 'engine'
                },
                {
                    data: 'fueltype',
                    name: 'fueltype'
                },
                {
                    data: 'color_exterior',
                    "render": function (data, type, full, meta) {
                        return "<div style='background-color:" + data + ";width: 20px;height: 20px'></div>";
                    },
                },
                {
                    data: 'color_interior',
                    "render": function (data, type, full, meta) {
                        return "<div style='background-color:" + data + ";width: 20px;height: 20px'></div>";
                    },
                },
                {
                    data: 'transmission',
                    name: 'transmission'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]

        });


        $(document).ready(function () {
            $(document).on('click', '.btn_edit', function (event) {

                $('input').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                event.preventDefault();
                var button = $(this);
                var uuid = button.data('uuid');
                $('#edit_model').val(button.data('model_id')).trigger('change');
                $('#edit_transmission').val(button.data('transmission_id')).trigger('change');
                $('#edit_brand').val(button.data('brand_id'));
                $('#edit_model').append('<option value="' + button.data('model_id') + '" selected>' + button
                    .data('model_name') + '</option>');
                // $('#edit_model').val( button.data('model_id'));
                $('#edit_engine').val(button.data('engine_id')).trigger('change');
                $('#edit_fuel').val(button.data('fueltype_id'));
                $('#edit_fuel').append('<option value="' + button.data('fueltype_id') + '" selected>' +
                    button.data('fueltype_name') + '</option>');
                $('#edit_color_exterior').val(button.data('color_exterior_id'));
                $('#edit_color_interior').val(button.data('color_interior_id'));
                $('#edit_lat').val(button.data('lat'))
                $('#edit_year').val(button.data('year')).trigger('change')
                $('#edit_lng').val(button.data('lng'))
                $('#edit_year_from').val(button.data('year_from'))
                $('#edit_year_to').val(button.data('year_to'))
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
            $('select[name="model_id"]').empty();
            // $('.search_input').val("").trigger("change")

        })
    </script>
    <script>
        $(document).ready(function () {
            $('select[name="brand_id"]').on('change', function () {
                var brand_id = $(this).val();
                if (brand_id) {
                    $.ajax({
                        url: "car/model" + "/" + brand_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="model_id"]').empty();
                            $('select[name="model_id"]').append(`
                                 <option selected  disabled>Select @lang('Model')</option>
                                 `)
                            $.each(data, function (key, value) {
                                $('select[name="model_id"]').append('<option value="' +
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
@endsection
