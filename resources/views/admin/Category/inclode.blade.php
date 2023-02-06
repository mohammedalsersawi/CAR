@foreach($category as $item)
    <tr>
        <th data-priority="1">{{$loop->index+1}}</th>
        <th data-priority="3">{{$item->name}}</th>
        <th><img src="{{asset('upload/images/category/'.$item->image)}}" height="50" width="50"></th>
        <th data-priority="2">{{$item->course()->count()}}</th>
        <th data-priority="2">{{$item->dest}}</th>
        <td>
            <div class="">
                <div class="btn-group me-1 mt-2">
                    <button type="button" class="btn btn-primary dropdown-toggle"
                            data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <i class="mdi mdi-chevron-down"></i></button>
                    <div class="dropdown-menu">
                        @can('category.edit')
                            <button class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#edit{{$item->id}}">
                                <i data-feather="edit-2" class="mr-50"></i>
                                <span>Edit</span>
                            </button>
                        @endcan
                        @can('category.delete')
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
                    <form action="{{route('Category.update',$item->id)}}" method="post"   enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name Category</label>
                            <input value="{{$item->name}}" type="text" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <input  accept="image/*" name="imagee" type="file" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Description</label>
                            <input value="{{$item->dest}}"  type="text" name="dest" class="form-control" id="exampleInputPassword1">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
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
                    <form action="{{route('Category.destroy',$item->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-primary">Sure</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
