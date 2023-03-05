
@foreach ($data as $itam)
    <div class="col">
        <div class="card">
            <input type="checkbox" class="form-check-input" id="vehicle1" name="vehicle1" value="Bike">
            <br>
            <img src="{{ asset('uploads/' . $itam->filename) }}" class="card-img-top" style="width:  200px; height: 200px"
                alt="Hollywood Sign on The Hill" />
            <div class="card-body">
                <button data-id="{{ $itam->id }}" class="btn btn-outline-danger" id="delete-image">
                    <span>@lang('delete')</span>
                </button>
                <button data-id="{{ $itam->id }}" class="btn btn-outline-success" id="edite-image"
                    data-toggle="modal" data-target="#edit_modal">
                    <span>@lang('edit')</span>
                </button>
            </div>
        </div>
    </div>
@endforeach
