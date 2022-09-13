@extends('admin.app')
@section('title') {{ 'Course' }} @endsection
@section('content')
   <div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> {{ 'Course' }}</h1>
            <p>{{ 'list of Courses' }}</p>
        </div>
        <a href="{{ route('admin.course.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
    </div>
    <div class="alert alert-success" id="success-msg" style="display: none;">
        <span id="success-text"></span>
    </div>
    <div class="alert alert-danger" id="error-msg" style="display: none;">
        <span id="error-text"></span>
    </div>
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped" id="" style="width: 100%!important;">
                        <thead>
                            <tr>
                                <th> Image</th>
                                <th> Created By</th>
                                <th> Name</th>
                                <th> Description</th>
                                <th> Price</th>
                                {{-- <th> Features</th> --}}
                                <th> Chapters</th>
                                <th> Status</th>
                                <th> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($course as $key => $cou)
                                <tr>
                                    <td><img src="{{asset($cou->course_image)}}" height="100" width="100"></td>
                                    <td>

                                    <ul>
                                        @php 
                                        $created_by = DB::table('admins')->where('id', $cou->teacherId)->where('is_active','1')->get();
                                        // $teacher = $cou->teacher;
                                         @endphp
                                        @foreach ($created_by as $item)
                                        <li>Name : {{$item->name}}</li>
                                        <li>Email : {{$item->email}}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                    <td>{{$cou->course_name}}</td>
                                    <td>{!! substr($cou->course_description, 0, strrpos(substr($cou->course_description, 0, 50), " ")).'...'!!}</td>
                                    <td>₹ {{$cou->price}}</td>
                                    {{-- <th><a href="{{route('admin.course.feature',$cou->id)}}">{{count($cou->feature)}}</a></th> --}}
                                    <th><a href="{{route('admin.course.chapters.index',$cou->id)}}">{{count($cou->overallchapter)}}</a></th>
                                    <th>
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="is_active" class="checkbox" data-course_id="{{$cou->id}}" @if($cou->is_verified == 1){{'checked'}}@endif>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <a href="{{route('admin.course.edit',$cou->id)}}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)" data-id="{{$cou->id}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                        
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                     {!! $course->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({"ordering": false});
       
        $(document).on('click','.sa-remove',function(){
                var CourseId = $(this).data('id');
                swal({
                  title: "Are you sure?",
                  text: "Your will not be able to recover the record!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-danger",
                  confirmButtonText: "Yes, delete it!",
                  closeOnConfirm: false
                },
                function(isConfirm){
                    if (isConfirm) {
                        window.location.href = "course/"+CourseId+"/delete";
                    } else {
                      swal("Cancelled", "Record is safe", "error");
                    }
                });
            });

            // status
            $(document).on('change','input[id="toggle-block"]',function(){
                var course_id = $(this).data('course_id');
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var is_verified = 0;
                if($(this).is(":checked")){
                    is_verified = 0;
                }else{
                    is_verified = 1;
                }
                $.ajax({
                    type:'POST',
                    dataType:'JSON',
                    url:"{{route('admin.course.updateStatus')}}",
                    data:{ _token: CSRF_TOKEN, id:course_id, is_verified:is_verified},
                    success:function(response)
                    {
                      swal("Success!", response.message, "success");
                    },
                    error: function(response)
                    {
                        
                      swal("Error!", response.message, "error");
                    }
                });
            });
    </script>
@endpush