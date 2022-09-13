@extends('admin.app')
@section('title') Questions @endsection
@section('content')
<div class="fixed-row">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file-text"></i> Questions</h1>
            <p>list of Questions</p>
        </div>

        <a href="{{ route('admin.question.create') }}" class="btn btn-primary pull-right">Add New</a>
    </div>
</div>
@include('admin.partials.flash')
<div class="alert alert-success" id="success-msg" style="display: none;">
    <span id="success-text"></span>
</div>
<div class="alert alert-danger" id="error-msg" style="display: none;">
    <span id="error-text"></span>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body" style="margin-top: 55px;">
                <table class="table table-hover custom-data-table-style table-striped" id="">
                    <thead>
                        <tr>
                            <td width="15%">Question</td>
                            <td>Chapter</td>
                            <td>Sub Chapter</td>
                            <!--<td>Answers1</td>-->
                            <!--<td>Answers2</td>-->
                            <!--<td>Answers3</td>-->
                            <!--<td>Answers4</td>-->
                            <!--<td>Mark Scheme</td>-->
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                        <tr>
                            <td><img src="{{asset($question->question)}}" height="100" width="200">
                                <span>{!! $question->question_title !!}</span>
                            </td>
                            <td>{{$question->chapter->name}}</td>
                            <td>{{$question->subChapter->name}}</td>
                            <!--<td>-->
                            <!--    @if($question->answer1 != '')-->
                            <!--    <a href="#AnswerModal" data-toggle="modal">Answer 1</a>-->
                            <!--    @else-->
                            <!--    {{('N/A')}}-->
                            <!--    @endif-->

                            <!--    <div id="AnswerModal" class="modal fade">-->
                            <!--        <div class="modal-dialog">-->
                            <!--            <div class="modal-content">-->
                            <!--                <div class="modal-body" id="AnswerModalShow">-->
                            <!--                    {{-- {!! $question->answer1 !!} --}}-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @if($question->answer2 != '')-->
                            <!--    <a href="#AnswerModal2" data-toggle="modal">Answer 2</a>-->
                            <!--    @else-->
                            <!--    {{('N/A')}}-->
                            <!--    @endif-->

                            <!--    <div id="AnswerModal2" class="modal fade">-->
                            <!--        <div class="modal-dialog">-->
                            <!--            <div class="modal-content">-->
                            <!--                <div class="modal-body" id="AnswerModalShow2">-->
                            <!--                    {{-- {!! $question->answer2 !!} --}}-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @if($question->answer3 != '')-->
                            <!--    <a href="#AnswerModal3" data-toggle="modal">Answer 3</a>-->
                            <!--    @else-->
                            <!--    {{('N/A')}}-->
                            <!--    @endif-->

                            <!--    <div id="AnswerModal3" class="modal fade">-->
                            <!--        <div class="modal-dialog">-->
                            <!--            <div class="modal-content">-->
                            <!--                <div class="modal-body" id="AnswerModalShow3">-->
                            <!--                    {{-- {!! $question->answer3 !!} --}}-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @if($question->answer4 != '')-->
                            <!--    <a href="#AnswerModal4" data-toggle="modal">Answer 4</a>-->
                            <!--    @else-->
                            <!--    {{('N/A')}}-->
                            <!--    @endif-->

                            <!--    <div id="AnswerModal4" class="modal fade">-->
                            <!--        <div class="modal-dialog">-->
                            <!--            <div class="modal-content">-->
                            <!--                <div class="modal-body" id="AnswerModalShow4">-->
                            <!--                    {{-- {!! $question->answer4 !!} --}}-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <!--<td>-->
                            <!--    @if($question->mark_scheme != '')-->
                            <!--    <a href="#MarkModal" data-toggle="modal">Mark Scheme</a>-->
                            <!--    @else-->
                            <!--    {{('N/A')}}-->
                            <!--    @endif-->

                            <!--    <div id="MarkModal" class="modal fade">-->
                            <!--        <div class="modal-dialog">-->
                            <!--            <div class="modal-content">-->
                            <!--                <div class="modal-body">-->
                            <!--                    <img src="{{ asset($question->mark_scheme) }}" width="100%"-->
                            <!--                        height="100%" alt="">-->
                            <!--                </div>-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</td>-->
                            <th>
                                <a href="{{route('admin.question.edit',$question->id)}}"
                                    class="btn btn-sm btn-primary edit-btn"><i class="fa fa-pencil"></i></a>
                                <a href="javascript:void(0)" data-id="{{$question->id}}"
                                    class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i>
                                </a>
            
                        </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            {!! $questions->links() !!}
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
@endpush
@push('scripts')
<script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable({
        "ordering": false
    });

    $(document).on('click', '.sa-remove', function () {
        var questionId = $(this).data('id');
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover the record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location.href = questionId + "/delete";
                } else {
                    swal("Cancelled", "Record is safe", "error");
                }
            });
    });

</script>

<script>
    // Modal 1
    $(document).ready(function() {
        var url = $("#AnswerModalShow").attr('src');
        $("#AnswerModal").on('hide.bs.modal', function() {
            $("#AnswerModalShow").attr('src', '');
        });
        $("#AnswerModal").on('show.bs.modal', function() {
            $("#AnswerModalShow").attr('src', url);
        });
    });
    // Modal 2
    $(document).ready(function() {
        var url = $("#AnswerModalShow2").attr('src');
        $("#AnswerModal2").on('hide.bs.modal', function() {
            $("#AnswerModalShow2").attr('src', '');
        });
        $("#AnswerModal2").on('show.bs.modal', function() {
            $("#AnswerModalShow2").attr('src', url);
        });
    });
    // Modal 3
    $(document).ready(function() {
        var url = $("#AnswerModalShow3").attr('src');
        $("#AnswerModal3").on('hide.bs.modal', function() {
            $("#AnswerModalShow3").attr('src', '');
        });
        $("#AnswerModal3").on('show.bs.modal', function() {
            $("#AnswerModalShow3").attr('src', url);
        });
    });
    // Modal 4
    $(document).ready(function() {
        var url = $("#AnswerModalShow4").attr('src');
        $("#AnswerModal4").on('hide.bs.modal', function() {
            $("#AnswerModalShow4").attr('src', '');
        });
        $("#AnswerModal4").on('show.bs.modal', function() {
            $("#AnswerModalShow4").attr('src', url);
        });
    });

</script>
@endpush
