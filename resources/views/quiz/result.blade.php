@extends('layouts.quiz')

@section('page_title')
Questionnaire Results
@endsection

@section('content')

<x-alert />
<style type="text/css">
	@media print{
   .update{
       display:none;
   }
}
</style>

<script src="{{ asset('public/lib/jSignature/jSignature.min.js') }}"></script>

<!-- this, preferably, goes inside head element: -->
<!--[if lt IE 9]>
<script type="text/javascript" src="{{ asset('public/lib/jSignature/flashcanvas.js') }}"></script>
<![endif]-->

<div class="page-tools update">
            <div class="action-buttons">
                <a class="btn btn-info printMe pull-right" href="#" data-title="Print">
                    <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                    Print
                </a>
                
            </div>
        </div>
        <?php /*
<br><h1 class="head1">Thank you.</h1>


@if( $todos->count() > 0 )
	
	<h1 class="head1">To Do List</h1>
	<table class="table table-striped table-bordered table-hover" align="center" width="80%" border="1">
		<thead>
			<tr>
				<th style="text-align: center;">Id</th>
				<th style="text-align: center;">To Do list</th>
			</tr>
		</thead>

		<tbody>
			@foreach( $todos as $todo )
				<tr class="odd gradeX">
					<td align="center">{{ $loop->iteration }}</td>
					<td>{{ $todo->todolist }}</td>
				</tr>
			@endforeach
		</tbody>

	</table>
@endif*/ ?>

<h1 class="head1">Questionnaire Results</h1>

@if( $result->answers->count() > 0 )
<style type="text/css">
	div#corrected {
    border: solid green;
    padding: 15px;
}

div#wrongans {
    border: solid red;
    padding: 15px;
}

</style>
 
	<form action="{{ route('quiz.result.update' ,$result_uuid ) }}" method="POST">
		@csrf
		
		@foreach( $result->answers as $key => $answer )
			
			<div class="form-group am here" @if( $answer->answer == $answer->question->right_answers) id="corrected" @else id="wrongans" @endif>
				
				<label for="name">{{ $loop->iteration . ') ' . $answer->question->title }}</label>
				<?php
				$right_answers = count( $answer->question->right_answers );
				$choice_type = 'radio';
				if( $right_answers > 1 ) {
					$choice_type = 'checkbox';
				}
				?>

				
				@foreach($answer->question->options as $option)
				
					<div class="{{ $choice_type }}">
						<label>
							<input type="{{ $choice_type }}" name="question_ans[{{$answer->question_id}}][]" <?php echo in_array( $option, $answer->answer ) ? 'checked' : ''; ?> @if( $answer->answer == $answer->question->right_answers) disabled @endif  value="{{ $option }}"/> {{ $option }}
						</label>
					</div>
				@endforeach

				@if( $answer->answer !== $answer->question->right_answers && $result->quiz_id == 6)
					<p class="form-control-static" style="color: #5cb85c;">Correct Answer: {{ implode(', ', $answer->question->right_answers) }}</p>
				@endif

			</div>
		@endforeach

		@if($acknowledgement_url)
		{{-- <a href="{{ $acknowledgement_url }}" class="btn btn-custom-success">Submit Acknowledgement</a> --}}
		@endif

		<button type="button" class="btn btn-custom-success btn-lg" data-toggle="modal" data-target="#submitAcknowledgementModal">Submit Acknowledgement</button>
		
		<input type="hidden" name="quiz_id" value="{{$result->quiz_id}}">
		<input type="hidden" name="result_id" value="{{ $result_id }}" />
		@if(count($result->answers) != $right_answers)
			<input type="submit" value="Update Answers" class="btn btn-success pull-right update">

		@endif
	</form>

	@include('quiz.employee-acknowledgement-modal')

@endif
<script type="text/javascript">
	$('.printMe').click(function(){
     window.print();
});
</script>
@endsection