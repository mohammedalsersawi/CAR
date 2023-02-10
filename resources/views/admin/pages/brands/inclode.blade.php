
@foreach($brand as $item)
    <tr id="row{{$item->id}}">
        <td>{{$item->id}}</td>
        <td>{{$item->name}}</td>
        <td><div class="container">
                <div class="col-md-4 px-0">
                    <img width="50" height="50" src="{{asset('upload/images/brand/'.$item->image)}}" class="img-fluid">
                </div>
            </div>
        </td>
        <td>
            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                    data-target="#edit{{ $item->id }}"
            ><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                    data-target="#delete{{ $item->id }}"
            ><i
                    class="fa fa-trash"></i></button>

        </td>
    </tr>

    <div class="modal fade" id="edit{{ $item->id }}"  tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                        id="exampleModalLabel">
                        {{ trans('Grades_trans.edit_Grade') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="{{ route('brand.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="Name"
                                       class="mr-sm-2">{{ trans('Grades_trans.stage_name_ar') }}
                                    :</label>
                                <input id="Name" type="text" name="Name"
                                       class="form-control"
                                       {{--                                                                       value="{{ $Grade->getTranslation('Name', 'ar') }}"--}}
                                       required>
                                <input id="id" type="hidden" name="id" class="form-control"
                                >
                            </div>
                            <div class="col">
                                <label for="Name_en"
                                       class="mr-sm-2">{{ trans('Grades_trans.stage_name_en') }}
                                    :</label>
                                <input type="text" class="form-control"
                                       {{--                                                                       value="{{ $Grade->getTranslation('Name', 'en') }}"--}}
                                       name="Name_en" required>
                            </div>
                        </div>
                        <br><br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ trans('Grades_trans.Close') }}</button>
                            <button type="submit"
                                    class="btn btn-success">{{ trans('Grades_trans.submit') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- delete_modal_Grade -->
    <div class="modal fade"
         id="delete{{ $item->id }}"
         tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                        id="exampleModalLabel">
                       @lang('delete Brand')
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_delete" data-action="{{ route('brand.destroy', 'tt') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            Do you want to delete the brand {{$item->name}} with all the courses above it?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">@lang('Close')</button>
                            <button type="button"
                                    onclick="deletebrand({{$item->id}})"
                                    class="btn btn-danger">@lang('Delte')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endforeach
