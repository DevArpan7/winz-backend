@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div class="active-wrap">
                <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" id="btnSave"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Quiz</button>
                    <a class="btn btn-secondary" href="{{ route('admin.quiz.index') }}"><i style="vertical-align: baseline;" class="fa fa-chevron-left"></i>Back</a>
                </div>
            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-12 mx-auto">
            <div class="tile">
                <form action="{{ route('admin.quiz.store') }}" method="POST" role="form" enctype="multipart/form-data" id="form1">
                    @csrf
                    <div class="tile-body form-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Select Board </label>
                            <select class="form-control @error('board_id') is-invalid @enderror" name="board_id" id="board_id">
                                <option value="">-- Select Board --</option>
                                @foreach($board as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('board_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Select Subject </label>
                            <select class="form-control @error('subject_id') is-invalid @enderror" name="subject_id" id="subject_id">
                                <option value="">-- Select Subject --</option>
                                @foreach($subject as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('subject_id') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Select Class </label>
                            <select class="form-control @error('class_id') is-invalid @enderror" name="class_id" id="class_id">
                                <option value="">-- Select Class --</option>
                                @foreach($class as $n)
                                <option value="{{$n->id}}">{{$n->name}}</option>
                                @endforeach
                            </select>
                            @error('class_id') {{ $message }} @enderror
                        </div>    
                        <div class="form-group">
                            <label class="control-label" for="question">Question <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('question') is-invalid @enderror" type="text" name="question" id="question" value="{{ old('question') }}"/>
                            
                            @error('question') {{ $message }} @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="option1">Option 1 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('option1') is-invalid @enderror" type="text" name="option1" id="option1" value="{{ old('option1') }}"/>
                            @error('option1') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="option2">Option 2 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('option2') is-invalid @enderror" type="text" name="option2" id="option2" value="{{ old('option2') }}"/>
                            @error('option2') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="option3">Option 3 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('option3') is-invalid @enderror" type="text" name="option3" id="option3" value="{{ old('option3') }}"/>
                            @error('option3') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="option4">Option 4 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('option4') is-invalid @enderror" type="text" name="option4" id="option4" value="{{ old('option4') }}"/>
                            @error('option4') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="option5">Option 5 <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('option5') is-invalid @enderror" type="text" name="option5" id="option5" value="{{ old('option5') }}"/>
                            @error('option5') {{ $message }} @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="answer">Answer <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('answer') is-invalid @enderror" type="text" name="answer" id="answer" value="{{ old('answer') }}"/>
                            @error('answer') {{ $message }} @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#btnSave").on("click",function(){
            $('#form1').submit();
        })
    })
</script>
@endpush