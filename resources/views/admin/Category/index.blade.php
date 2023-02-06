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
                                <h3 class="m-0"></h3>
                                @can('category.create')

                                <a href="{{route('Category.create')}}">  <button class="btn btn-success waves-effect waves-light">Add</button></a>
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
                                            <th data-priority="1">Image</th>
                                            <th data-priority="1">Number Courses</th>
                                            <th data-priority="1">Description</th>
                                            <th data-priority="3">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="comment-listtqq">
                                        @include('admin.Category.inclode',['category' => $category])

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $category->links() }}
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

<script>
    $("#searchTheKey").on('keyup', function(){
        var value = $(this).val().toLowerCase();

        $.ajax({
            type: 'GET',
            url: '{{route("Category.index")}}',
            data: {
                _token: '{{csrf_token()}}',
                value:value,

            },
            success: function (res) {

                $('#comment-listtqq').html(res);
            },
            error: function (data) {
               console.log('ssss')
            }
        });


    });

</script>

{{--<script>--}}
{{--    $(document).ready(function(){--}}
{{--        $("#searchTheKey").on("keyup", function() {--}}
{{--    var value = $(this).val().toLowerCase();--}}
{{--    $("#comment-listtqq tr").filter(function() {--}}
{{--        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)--}}
{{--    });--}}
{{--    });--}}
{{--    });--}}
{{--</script>--}}

@endsection
