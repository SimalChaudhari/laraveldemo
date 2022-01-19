@extends('layouts.quiz')

@section('page_title')
{{ $quiz->test_name }}
@endsection

@section('content')

<style type="text/css">
.box{
    padding: 10px;
    display: none;
    margin-top: 20px;
    border: 1px solid #000;
}
.red{ background: #ffffff; }
.green{ background: #ffffff; }
.blue{ background: #ffffff; }
</style>

<x-alert />

@if( $questions->count() > 0 )

	@foreach( $questions->items() as $question )

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><strong>Que {{ $question->question_number }}:</strong> {{ $question->que_desc }}</h3>
			</div>

			<div class="panel-body">

				<form id="question-{{ $questions->currentPage() }}" method="POST" action="{{ $questions->hasMorePages() ? $questions->nextPageUrl() : route('UI_showRiskAssessmentQuizResult', [ 'test_id' => $quiz->uuid, 'sess_id' => session()->getId() ] ) }}">

					@csrf

					<div class="form-group">

						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="yes" <?php echo $answer == 'yes' ? 'checked' : ''; ?> /> Yes
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="no" <?php echo $answer == 'no' ? 'checked' : ''; ?> /> No
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="quiz" value="review" <?php echo $answer == 'review' ? 'checked' : ''; ?> /> Review
							</label>
						</div>

					</div>

					<input type="hidden" name="qid" value="{{ $question->que_id }}" />



					@if( !empty( $question->todolist ) OR !is_null( $question->todolist ) )
						<div class="green box">
							{{ $question->todolist }}
						</div>
					@endif

					@if( !empty( $question->Definition ) && !empty( $question->Impact ) )
						<div class="tabber">

							<div class="tabbertab" title="Definition">
								<div class="multiple" style="border-top:1px dashed #999999; border-bottom:1px dashed #999999; margin:1%;">
									<h4 style="padding-top:0%;">Definition</h4>
								</div>
								{!! $question->Definition !!}
							</div>

							<div class="tabbertab" title="Impact">
								<div class="multiple" style="border-top:1px dashed #999999; border-bottom:1px dashed #999999; margin:1%;">
									<h4 style="padding-top:0%;">Impact</h4>
								</div>
								<p style=" text-align:justify; word-wrap: break-word;">{!! $question->Impact !!}</p>
							</div>

						</div>
					@endif

					<div class="text-center" style="margin-top: 15px;">
						@if( $questions->previousPageUrl() )
							<a href="{{ $questions->previousPageUrl() }}" class="btn btn-primary">&laquo; Previous Question</a>
						@endif
						
						@if( $questions->hasMorePages() )
							<input type="submit" name="next" class="btn btn-success" value="Next Question &raquo;" />
						@else
							<input type="submit" name="getResult" class="btn btn-danger" value="Get Result" />
						@endif
					</div>

				</form>

			</div>
		</div>

	@endforeach
	
@endif

@endsection