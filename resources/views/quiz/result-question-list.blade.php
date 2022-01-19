@foreach( $result->answers as $key => $answer )
			
	<div class="form-group" @if( $answer->answer == $answer->question->right_answers) id="corrected" @else id="wrongans" @endif style="margin-bottom: 30px;">
		
		<label class="col-md-12 col-xs-12" style="padding: 0">{{ $loop->iteration . ') ' . $answer->question->title }}</label>
		<?php
		$right_answers = count( $answer->question->right_answers );
		$choice_type = 'radio';
		if( $right_answers > 1 ) {
			$choice_type = 'checkbox';
		}
		?>

		
		@foreach($answer->question->options as $option)
		
			<div class="{{ $choice_type }}">
				<label class="col-md-12 col-xs-12">
					<input type="{{ $choice_type }}" name="question_ans[{{$answer->question_id}}][]" <?php echo in_array( $option, $answer->answer ) ? 'checked' : ''; ?> @if( $answer->answer == $answer->question->right_answers) disabled @endif  value="{{ $option }}"/> {{ $option }}
				</label>
			</div>
		@endforeach

		@if( $answer->answer !== $answer->question->right_answers && $result->quiz_id == 6)
			<p class="form-control-static" style="color: #5cb85c;">Correct Answer: {{ implode(', ', $answer->question->right_answers) }}</p>
		@endif

		<div class="clearfix"></div>

	</div>
@endforeach