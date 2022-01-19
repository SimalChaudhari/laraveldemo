@extends('layouts.quiz')

@section('content')

<x-alert />

<h1 class="style8" align="center">Welcome to HIPAA Security Risk Assessment</h1>

<table width="28%"  border="0" align="center">

	@if( $quizes->count() > 0 )
		@foreach( $quizes as $quiz )
			<tr>
				<td align="center">
					<a href=""><font size=4>Click Here To Start --> {{ $quiz->title }}</font></a>
				</td>
			</tr>
		@endforeach
	@else
		<tr>
			<td>Sorry! no quiz available.</td>
		</tr>
	@endif

</table>

@endsection