@extends('layouts.quiz')

@section('page_title')
{{ $quiz->name }}
@endsection

@section('content')

<x-alert />

<style type="text/css">
	ul.tabbernav:empty {
		display: none;
	}
</style>

@if( $questions->count() > 0 )

	<form id="question-{{ $questions->currentPage() }}" class="validateForm" method="POST" action="{{ $questions->hasMorePages() ? $questions->nextPageUrl() : route('UI_quizResult', $result_uuid ) }}">

		@csrf

		@foreach( $questions->items() as $question )

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><strong>Que {{ $question->question_order }}:</strong> {{ $question->title }}</h3>
				</div>

				<div class="panel-body">

					<div class="form-group">

						<?php
						$user_given_answers = has_user_given_answer( $result_id, $question->id );

						$right_answers = count( $question->right_answers );
						$choice_type = 'radio';
						if( $right_answers > 1 ) {
							$choice_type = 'checkbox';
						}
						?>

						@foreach( $question->options as $option )

							<div class="{{ $choice_type }}">
								<label>
									<input type="{{ $choice_type }}" name="answer[{{ $question->uuid }}][]" value="{{ $option }}" <?php echo in_array( $option, $user_given_answers ) ? 'checked' : ''; ?> class="validate[required]" data-errormessage-value-missing="Please select one of the following options to continue" /> {{ $option }}
								</label>
							</div>

						@endforeach

					</div>

					
					<div class="tabber" style="margin-bottom: 15px;">

						@if( $quiz->show_definition == 1 && !empty( $question->definition ) && $question->definition != '<p><br></p>' )
							<div class="tabbertab" title="Definition">
								<div class="multiple" style="border-top:1px dashed #999999; border-bottom:1px dashed #999999; margin:1%;">
									<h4 style="padding-top:0%;">Definition</h4>
								</div>
								{!! $question->definition !!}
							</div>
						@endif

						@if( $quiz->show_impact == 1 && !empty( $question->impact ) && $question->impact != '<p><br></p>' )
							<div class="tabbertab" title="Impact">
								<div class="multiple" style="border-top:1px dashed #999999; border-bottom:1px dashed #999999; margin:1%;">
									<h4 style="padding-top:0%;">Impact</h4>
								</div>
								<p style=" text-align:justify; word-wrap: break-word;">{!! $question->impact !!}</p>
							</div>
						@endif

					</div>
					

					<input type="hidden" name="que_id[]" value="{{ $question->uuid }}" />
					<input type="hidden" name="result_id" value="{{ $result_uuid }}" />

				</div>
			</div>

		@endforeach

		<div class="text-center">
			@if( $questions->previousPageUrl() )
				<a href="{{ $questions->previousPageUrl() }}" class="btn btn-primary">&laquo; Previous Question</a>
			@endif

			@if( $questions->hasMorePages() )
				<input type="submit" name="next" class="btn btn-success" value="Next Question &raquo;" />
			@else
				<input type="submit" name="getResult" class="btn btn-danger" value="Finish" />
			@endif
		</div>

	</form>
	
@endif

@endsection