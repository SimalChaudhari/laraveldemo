@extends('layouts.quiz')

@section('page_title')
{{ $quiz->test_name }}
@endsection

@section('content')

<x-alert />

@if( $questions->count() > 0 )

	@foreach( $questions->items() as $question )

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Que {{ $questions->currentPage() }}:</strong> {{ $question->question_name }}</h3>
			</div>

			<div class="panel-body">

				<form id="question-{{ $questions->currentPage() }}" method="POST" action="{{ $questions->hasMorePages() ? $questions->nextPageUrl() : route('UI_showQuizResult', [ 'test_id' => $quiz->uuid, 'sess_id' => session()->getId() ] ) }}">

					@csrf

					<div class="form-group">

						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="{{ $question->optionA }}" <?php echo $answer == strtolower( $question->optionA ) ? 'checked' : ''; ?> /> {{ $question->optionA }}
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="{{ $question->optionB }}" <?php echo $answer == strtolower( $question->optionB ) ? 'checked' : ''; ?> /> {{ $question->optionB }}
							</label>
						</div>

						@if( !empty( $question->optionC ) )
						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="{{ $question->optionC }}" <?php echo $answer == strtolower( $question->optionC ) ? 'checked' : ''; ?> /> {{ $question->optionC }}
							</label>
						</div>
						@endif

						@if( !empty( $question->optionD ) )
						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="{{ $question->optionD }}" <?php echo $answer == strtolower( $question->optionD ) ? 'checked' : ''; ?> /> {{ $question->optionD }}
							</label>
						</div>
						@endif

					</div>

					<input type="hidden" name="qid" value="{{ $question->id }}" />

					<div class="text-center">
						@if( $questions->previousPageUrl() )
							<a href="{{ $questions->previousPageUrl() }}" class="btn btn-primary">&laquo; Previous Question</a>
						@endif

						@if( $questions->hasMorePages() )
							<input type="submit" name="next" class="btn btn-success" value="Next Question &raquo;" />
							<input type="submit" name="getResult" class="btn btn-warning" value="Save Progress" />
						@else
							<input type="submit" name="getResult" class="btn btn-danger" value="Finish" />
						@endif
					</div>

				</form>

			</div>
		</div>

	@endforeach
	
@endif

@endsection