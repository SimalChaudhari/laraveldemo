@extends('layouts.quiz')

@section('page_title')
Welcome to HIPAA Security Risk Assessment
@endsection

@section('content')

<x-alert />

<style type="text/css">
	.jumbotron {
		background: transparent;
	}
	.jumbotron h1 {
		font-size: 3em;

	}
</style>

<div class="jumbotron" style="background: transparent;">
	
	@if( $quizes->count() > 0 )

		@foreach( $quizes as $quiz )

			<h1 class="style8" align="center">Welcome to HIPAA {{ $quiz->title }}</h1>

			<p class="text-center"><a href="{{ route('startRiskAssessmentQuiz', $quiz->uuid) }}" class="btn btn-custom-success btn-lg">Click here to start</a></p>

		@endforeach

	@else

		<p class="text-center">Sorry! no quiz available at the moment.</p>

	@endif
</div>

@endsection