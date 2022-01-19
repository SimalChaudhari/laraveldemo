@extends('layouts.quiz')

@section('page_title')
Welcome to {{ $quiz->name }}
@endsection

@section('content')

<x-alert />

<style type="text/css">
	.jumbotron1 {
		background: transparent;
	}
	.jumbotron1 h1 {
		font-size: 3em;

	}
	.jumbotron1 p, .jumbotron1 ul li {
		font-size: 18px;
	}
	.jumbotron1 ul li:last-child {
		margin-bottom: 20px;
	}
</style>

<div class="jumbotron1" style="background: transparent;">
	
	@if( $quiz !== null )

		<h1 class="style8" align="center">Welcome to {{ $quiz->name }}</h1>

		{!! $quiz->description !!}

		<p class="text-center"><a href="{{ route('beginQuiz', $quiz->uuid) }}{{ $start_page_query_string }}" class="btn btn-custom-success btn-lg">Click here to begin</a></p>

	@else

		<p class="text-center">Sorry! no quiz available at the moment.</p>

	@endif
</div>

@endsection