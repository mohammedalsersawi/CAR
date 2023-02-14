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
            <form action="{{ route('brand.update') }}" method="POST" id="form_edit" class=""
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
                    <div class="col-12">
                        <div>
                            <span class="btn btn-info btn-file ">
                                <span class="fileinput-new"> @lang('select_image')</span>
                                <span class="fileinput-exists"> @lang('select_image')</span>
                                <input type="file" name="image"></span>
                            <small class="text-danger last_name_error" id="image_error"></small>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button  class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" class="full-modal-stem" id="full-modal-stem" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('brand.store') }}" method="POST" id="add-mode-form" class="add-mode-form"
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
                                    id="name_{{ $key }}">
                                <small class="text-danger last_name_error" id="name_{{ $key }}_error"></small>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12">
                        <div>
                            <span class="btn btn-info btn-file ">
                                <span class="fileinput-new"> @lang('select_image')</span>
                                <span class="fileinput-exists"> @lang('select_image')</span>
                                <input type="file" name="image"></span>
                            <small class="text-danger last_name_error" id="image_error"></small>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" >Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
