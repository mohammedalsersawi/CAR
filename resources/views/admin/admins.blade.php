@extends('admin.master')


@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <div class="page-title">
                        <h4 class="mb-0 font-size-18">Responsive Table</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Agroxa</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">Responsive Table</li>
                        </ol>
                    </div>

                    <div class="state-information d-none d-sm-block">
                        <div class="state-graph">
                            <div id="header-chart-1"></div>
                            <div class="info">Balance $ 2,317</div>
                        </div>
                        <div class="state-graph">
                            <div id="header-chart-2"></div>
                            <div class="info">Item Sold 1230</div>

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
                            <div class="d-flex justify-content-between align-items-center">
                                @can('admin.delete')
                                <h3 class="m-0"></h3>
                                <button  data-bs-toggle="modal" data-bs-target="#add" class="btn btn-success waves-effect waves-light">Add</button>
                                @endcan
                            </div>

                            <br><br>
                            <div class="table-rep-plugin">

                                <div class="table- mb-0" data-pattern="priority-columns">
                                    <table id="tech-companies-1" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th data-priority="1">#</th>
                                            <th data-priority="3">Name</th>
                                            <th data-priority="1">Email</th>
                                            <th data-priority="1">Phone</th>
                                            <th data-priority="3">Status</th>
                                            <th data-priority="3">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($admins as $item)
                                            <tr>
                                                <th data-priority="1">{{$loop->index+1}}</th>
                                                <th data-priority="3">{{$item->name}}</th>
                                                <th data-priority="3">{{$item->email}}</th>
                                                <th data-priority="3">{{$item->phone}}</th>
                                                <th data-priority="3">{{($item->status)}}</th>


                                                <td>
                                                    <div class="">
                                                        <div class="btn-group me-1 mt-2">
                                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                <i class="mdi mdi-chevron-down"></i></button>
                                                            <div class="dropdown-menu">
                                                                @can('admin.edit')
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#edit{{$item->id}}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>Edit</span>
                                                                </button>
                                                                @endcan
                                                                    @can('admin.delete')
                                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                                        data-bs-target="#delete{{$item->id}}">
                                                                    <i data-feather="edit-2" class="mr-50"></i>
                                                                    <span>Delete</span>
                                                                </button>
                                                                    @endcan
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="edit{{$item->id}}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="needs-validation" novalidate method="post" action="{{route('admin.update',$item->id)}}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('put')
                                                                <div class="row">
                                                                    <div class="col-md-10">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="validationCustom01">
                                                                                name</label>
                                                                            <input type="text" class="form-control" id="validationCustom01"
                                                                                   placeholder="name" value="{{$item->name}}" name="name" required>
                                                                            <div class="valid-feedback">
                                                                                Looks good!
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Col -->
                                                                    <div class="col-md-10">
                                                                        <div class="mb-3">
                                                                            <label class="form-label" for="validationCustom02">Email</label>
                                                                            <input type="email" class="form-control" id="validationCustom02"
                                                                                   placeholder="Email" value="{{$item->email}}"  name="email" required>
                                                                            <div class="valid-feedback">
                                                                                Looks good!
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Col -->
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="validationCustom03">Phone</label>
                                                                        <input type="text" name="phone" value="{{$item->phone}}" class="form-control" id="validationCustom03"
                                                                               placeholder="Phone" required>
                                                                        <div class="invalid-feedback">
                                                                            Please provide a valid city.
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End Row -->

                                                                <div class="row">
                                                                    <label class="form-label" >Status</label>
                                                                    <input name="status" type="checkbox" id="switch1" value="Active" switch="none" {{($item->status =='Active')? 'checked':''}}  />
                                                                    <label class="form-label form-control mx-3 " for="switch1" data-on-label="On"
                                                                           data-off-label="Off"></label>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label>Image</label>
                                                                    <input  accept="image/*" name="imagee" type="file" class="form-control" />
                                                                </div>
                                                                <div class="mb-5">
                                                                    <label>Roles</label>
                                                                    @php
                                                                    $role_admin=$item->roles->pluck('id')->toArray();
                                                                    @endphp

                                                                    @foreach($roles as $itemm)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" name="roles[]" type="checkbox" value="{{$itemm->id}}" id="flexCheckDefault" @checked(in_array($itemm->id, old('roles',$role_admin )))>
                                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                                {{$itemm->name}}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach


                                                                </div>

                                                                <br>
                                                                <!-- End Row -->


                                                                <!-- End Row -->
                                                                <button class="btn btn-primary" type="submit">Submit form</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal -->
                                            <div class="modal fade" id="delete{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Do you want to delete the category {{$item->name}} with all the courses above it?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="{{route('admin.destroy',$item->id)}}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-primary">Sure</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        </tbody>
                                        <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Add New Admin</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div >
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form class="needs-validation" novalidate method="post" action="{{route('admin.store')}}"  enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="validationCustom01">
                                                                                        name</label>
                                                                                    <input type="text" class="form-control" id="validationCustom01"
                                                                                           placeholder=" name" name="name" required>
                                                                                    <div class="valid-feedback">
                                                                                        Looks good!
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->
                                                                                <div class="col-md-10">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="validationCustom02">Email</label>
                                                                                    <input type="email" class="form-control" id="validationCustom02"
                                                                                           placeholder="Email" name="email" required>
                                                                                    <div class="valid-feedback">
                                                                                        Looks good!
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <div class="mb-3">
                                                                                <label class="form-label" for="validationCustom03">Phone</label>
                                                                                <input type="text" name="phone" class="form-control" id="validationCustom03"
                                                                                       placeholder="Phone" required>
                                                                                <div class="invalid-feedback">
                                                                                    Please provide a valid city.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Row -->

                                                                        <div class="row">

                                                                            <!-- End Col -->
                                                                            <div class="col-md-4">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="validationCustom04">Password</label>
                                                                                    <input type="password" name="password" class="form-control" id="validationCustom04"
                                                                                           placeholder="Password" required>
                                                                                    <div class="invalid-feedback">
                                                                                        Please provide a valid state.
                                                                                    </div>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label class="form-label" for="validationCustom04">PasswordConfirmation</label>
                                                                                    <input type="password" name="password_confirmation" class="form-control" id="validationCustom04"
                                                                                           placeholder="PasswordConfirmation" required>
                                                                                    <div class="invalid-feedback">
                                                                                        Please provide a valid state.
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label>Image</label>
                                                                                <input  accept="image/*" name="imagee" type="file" class="form-control" />
                                                                            </div>
                                                                            <div class="mb-5">
                                                                                <label>Roles</label>

                                                                                @foreach($roles as $item)
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input" name="roles[]" type="checkbox" value="{{$item->id}}" id="flexCheckDefault">
                                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                                            {{$item->name}}
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach


                                                                            </div>
                                                                            <!-- End Col -->

                                                                            <!-- End Col -->
                                                                        </div>
                                                                        <!-- End Row -->


                                                                        <!-- End Row -->
                                                                        <button class="btn btn-primary" type="submit">Submit form</button>
                                                                    </form>
                                                                    <!-- End Form -->
                                                                </div>
                                                            </div>
                                                            <!-- End Card -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->

        </div>
        <!-- End Page-content-wrapper -->

    </div>


@section('script')

    <script src="{{ asset('adminassets/js/pages/form-validation.init.js')}}"></script>
    <script src="{{ asset('adminassets/libs/parsleyjs/parsley.min.js')}}"></script>


@endsection


@endsection
