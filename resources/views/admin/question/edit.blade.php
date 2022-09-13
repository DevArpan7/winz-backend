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
                <h3 class="tile-title">{{ 'Update Question' }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.question.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.question.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    {{-- <input type="hidden" name="chapterId" value="{{$chapterId}}">
                    <input type="hidden" name="subChapterId" value="{{$subChapterId}}"> --}}
                    
                    <input type="hidden" name="question_id" value="{{$question->id}}">
                    {{-- <input type="hidden" id="chapter_id" value="{{$question->chapterId}}"> --}}
                    <div class="tile-body">
                        <img src="{{asset($question->question)}}" height="100" width="200">
                        <div class="form-group">
                            <label class="control-label" for="question"> Question <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="question" id="question">
                            @error('question') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                    <h5>Or</h5>
                    <div class="form-group">
                        <label class="control-label" for="question_title"> Question <span class="m-l-5 text-danger"> *</span></label>
                        <textarea id="question_title" name="question_title">{{$question->question_title}}</textarea>
                        @error('question_title') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                    </div>
                        <div class="form-group">
                            <label class="control-label" for="difficulty"> Difficulty <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('difficulty') is-invalid @enderror" name="difficulty" id="difficulty">
                                <option value="">-- Select Difficulty --</option>
                                <option value="1" {{($question->difficulty == 1)? 'selected': ''}}>Easy</option>
                                <option value="2" {{($question->difficulty == 2)? 'selected': ''}}>Medium</option>
                                <option value="3" {{($question->difficulty == 3)? 'selected': ''}}>Hard</option>
                            </select>
                            @error('difficulty') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="category"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $index =>$item)
                                <option value="{{$item->id}}" {{ ($question->categoryId == $item->id) ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('category') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="courses"> Course <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('courses') is-invalid @enderror" name="courses" id="courses">
                                {{-- <option value="">-- Select Course --</option> --}}
                                @foreach ($courses as $index =>$item)
                                <option value="{{ $item->id }}" {{ $question->courseId == $item->id ? 'selected' : ''}}>{{ $item->course_name }}</option>
                                @endforeach
                            </select>
                            @error('courses') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="chapters"> Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('chapters') is-invalid @enderror" name="chapters" id="chapters">
                                <option value="{{ $question->chapterId }}">{{ $question->chapter->name }}</option>
                            </select>
                            @error('chapters') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="subchapter"> Sub Chapter <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('subchapter') is-invalid @enderror" name="subchapter" id="subchapter">
                                <option value="{{ $question->subChapterId }}">{{ $question->subchapter->name }}</option>
                            </select>
                            @error('subchapter') {{ $message }} @enderror
                        </div>

                        <img src="{{asset($question->mark_scheme)}}" height="100" width="200">
                        <div class="form-group">
                            <label class="control-label" for="mark_scheme"> Mark Scheme <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control" type="file" name="mark_scheme" id="mark_scheme">
                            @error('mark_scheme') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer1"> Answer 1 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" name="answer1" class="form-control" value="{{$question->answer1}}">
                            @error('answer1') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="answer2"> Answer 2 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" name="answer2" class="form-control" value="{{$question->answer2}}">
                            @error('answer2') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer3"> Answer 3 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" name="answer3" id="answer3" class="form-control" value="{{$question->answer3}}">
                            @error('answer3') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer4"> Answer 4 <span class="m-l-5 text-danger"> *</span></label>
                            <input type="text" name="answer4" id="answer4" class="form-control" value="{{$question->answer4}}">
                            @error('answer4') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control ckeditor" name="description" id="description">{{$question->description}}</textarea>
                            @error('description') <span class="text-danger">{{ $message ?? '' }}</span> @enderror
                        </div> --}}

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
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
        // ClassicEditor
        //     .create( document.querySelector( '#description' ) )
        //     .catch( error => {
        //     console.error( error );
        // } );
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


        $('#chapters').change(function () {
        var id = $(this).val();
        var rootUrl = "{{ url('admin/questions/subchapter/fetch') }}/" + id;
        // AJAX request 
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

