@extends('layouts.admin')

@section('page_title')
Online forms
@endsection

@section('content')

<x-alert />

<h2>Online Forms</h2>

<table width="80%" border="1">
	<tr>
	    <th style="padding:1%;">No.</th>
	    <th style="padding:2%;">File Name</th>    
	    <th style="padding:2%;">View</th>
	</tr>

	@foreach( $forms as $form )

	<tr>
		<td style="padding:2%;">{{ $loop->iteration }}</td>
		<td style="padding:2%;">{{ $form['title'] }}</td>
		<td style="padding:2%;"><a href="{{ route($form['add_route']) }}" >Add New Record</a></td>
	</tr>

	@endforeach

</table>

@endsection