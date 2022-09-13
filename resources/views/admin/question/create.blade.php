@extends('admin.app')
@section('title') {{ 'Question' }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ 'Question' }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ 'Create Question' }} 
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.question.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="question"> Question <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="question" id="question">
                            @error('question') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <h5>Or</h5>
                        <div class="form-group">
                            <label class="control-label" for="question_title">Question <span class="m-l-5 text-danger"> *</span></label>
                            <textarea id="question_title" name="question_title">{{old('question_title')}}</textarea>
                            @error('question_title') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="difficulty"> Difficulty <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                <option value="">-- Select Difficulty --</option>
                                <option value="1">Easy</option>
                                <option value="2">Medium</option>
                                <option value="3">Hard</option>
                            </select>
                            @error('difficulty') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                <option value="">-- Select category --</option>
                                @foreach ($categories as $index =>$item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="courses"> Course <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('courses') is-invalid @enderror" name="courses" id="courses">
                                <option value="">-- Select Course --</option>
                                @foreach ($courses as $index =>$item)
                                <option value="{{ $item->id }}">{{ $item->course_name }}</option>
                                @endforeach
                            </select>
                            @error('courses') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="chapters"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('chapters') is-invalid @enderror" name="chapters" id="chapters">
                                <option value="">-- Select Chapter --</option>
                            </select>
                            @error('chapters') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subchapter"> Sub Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('subchapter') is-invalid @enderror" name="subchapter" id="subchapter">
                                <option value="">-- Select Sub Chapter --</option>
                            </select>
                            @error('subchapter') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="mark_scheme"> Mark Scheme <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="mark_scheme" id="mark_scheme">
                            @error('mark_scheme') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer1"> Answer 1 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" id="answer1" name="answer1" class="form-control" value="{{old('answer1')}}">
                            @error('answer1') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer2"> Answer 2 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" id="answer2" name="answer2" class="form-control" value="{{old('answer2')}}">
                            @error('answer2') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer3"> Answer 3 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" id="answer3" name="answer3" class="form-control" value="{{old('answer3')}}">
                            @error('answer3') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="answer4"> Answer 4 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" id="answer4" name="answer4" class="form-control" value="{{old('answer4')}}">
                            @error('answer4') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description"></textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div> --}}

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Create</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // ClassicEditor
        //     .create( document.querySelector( '#answer1' ) )
        //     .catch( error => {
        //     console.error( error );
        // } );
        // ClassicEditor
        //     .create( document.querySelector( '#answer2' ) )
        //     .catch( error => {
        //     console.error( error );
        // } );
        // ClassicEditor
        //     .create( document.querySelector( '#answer3' ) )
        //     .catch( error => {
        //     console.error( error );
        // } );
        // ClassicEditor
        //     .create( document.querySelector( '#answer4' ) )
        //     .catch( error => {
        //     console.error( error );
        // } );
        ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
            console.error( error );
        } );
        ClassicEditor
            .create( document.querySelector( '#question_title' ) )
            .catch( error => {
            console.error( error );
        } );

        $('#courses').change(function () {
        var id = $(this).val();
        var rootUrl = "{{ url('admin/subject-chapters/chapter/fetch') }}/" + id;
        // Course AJAX request 
            $.ajax({
                url: rootUrl,
                type: 'GET',
                dataType: 'json',
                success: function (response) {

                        var options = '<option value="" selected="" hidden="">Select Chapter</option>';
                        $.each(response.name, function(key, val) {
                            options += '<option value="' + val.id + '">' + val.name + '</option>';
                        });
                        $('#chapters').empty().append(options);
                }
            });
        });
        //Chapter AJAX request 
        $('#chapters').change(function () {
        var id = $(this).val();
        var rootUrl = "{{ url('admin/questions/subchapter/fetch') }}/" + id;
            $.ajax({
                url: rootUrl,
                type: 'GET',
                dataType: 'json',
                success: function (response) {

                        var options = '<option value="" selected="" hidden="">Select Sub Chapter</option>';
                        $.each(response.name, function(key, val) {
                            options += '<option value="' + val.id + '">' + val.name + '</option>';
                        });
                        $('#subchapter').empty().append(options);
                }
            });
        });
    </script>
@endsection


