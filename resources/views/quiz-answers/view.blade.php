@extends('layouts.admin')

@section('page_title')
Risk Assessment / Training Answers
@endsection

@section('content')

<style type="text/css">
	@media print {
		.printPageButton {
			display: none;
		}
	}
</style>

<x-alert />

<div class="main-content">

	<button class="printPageButton" onclick="printAnswers()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

	

	<h1 class="head1">{{ $result->name }} Results</h1>

	<table class="table table-striped table-bordered table-hover" align="center" width="80%" border="1">

		<thead>
			<tr>
				<th>Id</th>
				<th>Question</th>
				<th>Answer</th>
				<th>Correct Answer</th>
			</tr>
		</thead>

		<tbody>
			@if($result->answers->count() > 0)

				@foreach( $result->answers as $answer )

					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $answer->question->title }}</td>
						<td>{{ implode( ', ', $answer->answer ) }}</td>
						<td>{{ implode( ', ', $answer->question->right_answers ) }}</td>

					</tr>

				@endforeach

			@else

				<tr>
					<td colspan="4">Sorry! No answers found.</td>
				</tr>

			@endif
		</tbody>

	</table>

	

</div>

<button class="printPageButton" onclick="printAnswers()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>

<script>
function printAnswers() {
    window.print();
}
</script>

@endsection