@extends('layouts.quiz')

@section('page_title')
Thank you
@endsection

@section('content')

<x-alert />

<h1 class="head1">Thanks For the Exam.</h1>

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
@endif

<h1 class="head1">List Of Answers</h1>

@if( $answers->count() > 0 )
	
	<table class="table table-striped table-bordered table-hover" align="center" width="80%" border="1">
		<thead>
			<tr>
				<th style="text-align: center;">Id</th>
				<th align="center" style="padding:1%;">Question</th>
				<th style="text-align:center;">Answer</th>
			</tr>
		</thead>

		<tbody>
			@foreach( $answers as $answer )
				<tr class="odd gradeX">
					<td align="center">{{ $loop->iteration }}</td>
					<td>{{ $answer->question_name }}</td>
					<td>{{ $answer->your_ans }}</td>
				</tr>
			@endforeach
		</tbody>

	</table>
@endif

@endsection