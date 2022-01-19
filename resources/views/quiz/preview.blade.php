@extends('layouts.admin')

@section('page_title')
Preview: {{ $quiz->name }}
@endsection

@section('content')

<x-alert />

<script src="{{ asset( 'public/lib/Sortable/Sortable.js') }}"></script>

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

    	<div class="panel panel-default panel-custom">

    		<div class="panel-heading">
    			<div class="row">
					<div class="col-sm-6 col-xs-6">
						<h3 class="panel-title"><i class="fa fa-2x fa-puzzle-piece" aria-hidden="true"></i> Preview: {{ $quiz->name }}</h3>
					</div>
					<div class="col-sm-6 col-xs-6">
						<div class="btn-toolbar">
							@can('List Questions')
				            <a href="{{ route('question.index') }}" class="btn btn-custom-primary pull-right">
				                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>&nbsp; Questions
				            </a>
				            @endcan
				            @can('Quiz Crud Module')
				            <a href="{{ route('quiz.index') }}" class="btn btn-custom-danger pull-right">
				                &laquo; Back to Quiz
				            </a>
				            @endcan
				            @can('List Questions')
								@if($isSuperAdmin)
								<a href="{{ route('question.set.order', $quiz->uuid) }}" id="btn_save_order" class="btn btn-custom-primary pull-right">
									Save Order
								</a>
								@endif
				            @endcan
				        </div>
					</div>
				</div>
    		</div>

    		<div class="panel-body" style="padding: 0;">
    			
    			<form id="formQuestions" method="post" action="{{ route('question.set.order', $quiz->uuid) }}">

    				@csrf

    				<input type="hidden" name="quiz_uuid" value="{{ $quiz->uuid }}" />

	    			<ul id="quiz_question_list" class="list-group" style="margin-bottom: 0;">

	    				@foreach( $quiz->questions as $key => $question )
		    			<li class="list-group-item">
		    				<input type="hidden" name="hi_questions[]" class="question_uuids" value="{{ $question->uuid }}" />
							<label for="name">{{ $loop->iteration . ') ' .$question->title }}</label>
							<?php
							$right_answers = count( $question->right_answers );
							$choice_type = 'radio';
							if( $right_answers > 1 ) {
								$choice_type = 'checkbox';
							}
							?>
							@foreach($question->options as $option)
								<div class="{{ $choice_type }}">
									<label>
										<input type="{{ $choice_type }}" name="option{{ $key }}" <?php echo in_array( $option, $question->right_answers ) ? 'checked' : ''; ?>  /> {{ $option }}
									</label>
								</div>
							@endforeach
						</li>
						@endforeach

						<li class="list-group-item">
							<input type="submit" name="save_order" class="btn btn-custom-primary" value="Save Order" />
						</li>
					</ul>

				</form>

    		</div>

    	</div>

	</div>

	<div class="col-sm-2 col-xs-12"></div>

</div>

<script>
	$(document).ready(function() {
		new Sortable(quiz_question_list, {
			/*swap: true,
			swapClass: 'highlight',*/
		    animation: 150,
		    ghostClass: 'blue-background-class'
		});

		$(document).on('click', '#btn_save_order', function(e) {
			e.preventDefault();

			$('form#formQuestions').submit();
		});

	});
</script>
@endsection