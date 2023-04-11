@extends('part.app')
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
                        <h2 class="content-header-title float-left mb-0"> @lang('images_car')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">@lang('home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                            href="{{ route('orders.index') }}">@lang('images_car')</a>
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
                            <div class="row row-cols-1 row-cols-md-3 g-4" id="images-crad" style="margin-right: 120px">


                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>


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
                <form action="{{ route('ads.car.updateImages') }}" method="POST" id="form_edit_image" class="form_edit"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="uuid" name="uuid">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone">@lang('image')</label>
                                    <input type="file" class="form-control" placeholder="@lang('image')"
                                           name="car_image" id="">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('close')</button>
                        <button class="btn btn-primary">@lang('save changes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            loadCard();
        });

        $(document).on("click", "#delete-image", function (e) {
            var button = $(this)
            Swal.fire({
                title: '@lang('delete_confirmation')',
                text: '@lang('confirm_delete')',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('yes')',
                cancelButtonText: '@lang('cancel')',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger'
                },
                buttonsStyling: true
            }).then(function (result) {
                if (result.value) {
                    var id = button.data('id')
                    var url = window.location.href + '/' + id;
                    alert(url)
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(function () {
                        toastr.success('@lang('deleted')', '', {
                            rtl: isRtl
                        });
                        loadCard();

                    }).fail(function () {
                        toastr.error('@lang('something_wrong')', '', {
                            rtl: isRtl
                        });
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    toastr.info('@lang('delete_canceled')', '', {
                        rtl: isRtl
                    })
                }
            });
        });

        function loadCard() {
            var uuid = @json($uuid);
            $.ajax({
                url: '{{ route('ads.car.showCard') }}',
                data: {
                    'uuid': uuid
                },
                success: function (response) {
                    $("#images-crad").html(response);
                },
            });
        };

        $(document).on("click", "#edite-image", function (e) {
            $('#uuid').val('');
            var data_btm = $(this)
            var id = data_btm.data('id')
            $('#uuid').val(id);
        })


        $('#form_edit_image').on('submit', function (event) {
            event.preventDefault();
            var data = new FormData(this);
            let url = $(this).attr('action');
            let method = $(this).attr('method');
            $.ajax({
                type: method,
                cache: false,
                contentType: false,
                processData: false,
                url: url,
                data: data,
                beforeSend: function () {
                    $('input').removeClass('is-invalid');
                    $('.text-danger').text('');
                    $('.btn-file').addClass('');
                },
                success: function (result) {
                    $('#edit_modal').modal('hide');
                    $('.form_edit').trigger("reset");
                    toastr.success('@lang('done_successfully')', '', {
                        rtl: isRtl
                    });
                    loadCard();

                },
                error: function (data) {

                    if (data.status === 422) {

                        var response = data.responseJSON;
                        $.each(response.errors, function (key, value) {
                            var str = (key.split("."));
                            if (str[1] === '0') {
                                key = str[0] + '[]';
                            }
                            $('[name="' + key + '"], [name="' + key + '[]"]').addClass(
                                'is-invalid');
                            $('[name="' + key + '"], [name="' + key + '[]"]').closest(
                                '.form-group').find('.invalid-feedback').html(value[0]);
                        });
                    } else {
                        toastr.error('@lang('something_wrong')', '', {
                            rtl: isRtl
                        });
                    }
                }
            });
        })
    </script>
@endsection
