<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('engines.update') }}" method="POST" id="form_edit" class=""
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" class="form-control" />
                <div class="modal-body">
                    @foreach (locales() as $key => $value)
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name_{{ $key }}">@lang('name') @lang($value)</label>
                                <input type="text" class="form-control"
                                    placeholder="@lang('name') @lang($value)" name="name_{{ $key }}"
                                    id="edit_name_{{ $key }}">
                                <small class="text-danger last_name_error" id="name_{{ $key }}_error"></small>
                            </div>
                        </div>
                    @endforeach

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button class="btn btn-primary">@lang('save changes')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="full-modal-stem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">@lang('add')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('engines.store') }}" method="POST" id="add_model_form" class="add-mode-form">

                <input type="hidden" name="id" id="id" class="form-control" />
                <div class="modal-body">
                    @foreach (locales() as $key => $value)
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name_{{ $key }}">@lang('name') @lang($value)</label>
                                <input type="text" class="form-control"
                                       placeholder="@lang('name') @lang($value)" name="name_{{ $key }}"
                                       id="name_{{ $key }}">
                                <small class="text-danger last_name_error" id="name_{{ $key }}_error"></small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                    <button type="submit" class="btn btn-primary">@lang('add')</button>
                </div>
            </form>
        </div>
    </div>
</div>
