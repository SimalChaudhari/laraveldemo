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
	.panel .question_separator {
		border: 1px dashed #dedede;
		margin-bottom: 15px;
	}
</style>

<?php

$tabs = [
	1 => 'Documentation',
	2 => 'Workstations',
	3 => 'Access',
	4 => 'Unique User Identifier',
	5 => 'Encryption',
	6 => 'Back-up Procedures',
	7 => 'Physical Security',
	8 => 'Training and Awareness',
	9 => 'Business Associate Agreements',
	10 => 'Emergency Planning',
	11 => 'Incident Response Plan',
	12 => 'Audit Control'
];

?>

<div class="panel-group" id="accordion_question_category">

	<?php foreach( $tabs as $tab_index => $tab_name ) { ?>

	<div class="panel panel-default">

		<?php
		$is_current_tab_active = false;
		if( $questions->currentPage() == $tab_index ) {
			$is_current_tab_active = true;
		}
		?>

		<div class="panel-heading">

			<h4 class="panel-title">
				<?php if( $is_current_tab_active ) { ?>

					<a data-toggle="collapse" data-parent="#accordion_question_category" 
						data-current_tab_index="{{ $tab_index }}"
						href="#{{ sanitize_str( $tab_name ) }}Wrapper"
						style="font-weight: bold;color: #006dcc;font-size: 22px;">{{ $tab_name }}</a>

				<?php } else { ?>

					<p style="margin-bottom: 0;">{{ $tab_name }}</p>

				<?php } ?>	
			</h4>

		</div>

		

		<div id="{{ sanitize_str( $tab_name ) }}Wrapper" class="panel-collapse collapse <?php echo $is_current_tab_active ? 'in' : ''; ?>">

			<div class="panel-body">

				<?php if ( $is_current_tab_active ) { ?>

				<form id="question-{{ $questions->currentPage() }}" class="validateForm" method="POST" action="{{ $questions->hasMorePages() ? $questions->nextPageUrl() : route('UI_quizResult', $result_uuid ) }}">

					@csrf

					@foreach( $questions->items() as $question )
						
						<h3 style="margin-top: 0;line-height: 25px;"><strong>Que {{ $question->question_order }}:</strong> {{ $question->title }}</h3>

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

						<div class="question_separator"></div>

					@endforeach

					<div class="text-center">
						@if( $questions->previousPageUrl() )
							<a href="{{ $questions->previousPageUrl() }}" class="btn btn-primary pull-left">&laquo; Previous tab</a>
						@endif

						@if( $questions->hasMorePages() )
							<input type="submit" name="next" class="btn btn-success pull-right" value="Next tab &raquo;" />
						@else
							<input type="submit" name="getResult" class="btn btn-custom-danger pull-right" value="Finish Quiz" />
						@endif
					</div>

				</form>

				<?php } // endif ( $is_current_tab_active ) ?>

			</div>

		</div>

	</div>
	<?php } // endforeach( $tabs as $tab_name ) { ?>

</div>

@if( $questions->count() > 0 )

	
	
@endif

@endsection