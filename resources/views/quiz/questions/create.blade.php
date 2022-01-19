@extends('layouts.admin')

@section('page_title')
Create Question
@endsection

@section('content')

<?php $required_field_html = '<span style="color: red;">*</span>'; ?>

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.min.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/blackboard.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/theme/monokai.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<div class="row">

    <div class="col-sm-2 col-xs-12"></div>

    <div class="col-sm-8 col-xs-12">

    	<x-alert />
        
        <div class="panel panel-default panel-custom">

        	<div class="panel-heading">
        		<div class="row">
					<div class="col-sm-12 col-xs-12">
						<h3 class="panel-title"><i class="fa fa-2x fa-question-circle" aria-hidden="true"></i> Create Question</h3>
					</div>
				</div>
        	</div>

            <div class="panel-body">

            	<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form action="{{ route('question.store') }}" class="validateForm" method="POST" enctype="multipart/form-data" role="form">
					@csrf

					<div class="form-group">
						<label for="quiz_id">Quiz{!! $required_field_html !!}</label>
						<select name="quiz_id" class="form-control validate[required]">
							<option value="">Select Quiz</option>
							@if( $quizes->count() > 0 )
								@foreach( $quizes as $quiz )
									<option value="{{ $quiz->uuid }}">{{ $quiz->name }}</option>
								@endforeach
							@endif
						</select>

						@error('quiz_id')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="title">Question{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required]" name="title" value="{{ old('title') }}" />

						@error('title')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="definition">Definition</label>
						<textarea class="summernote" name="definition">{{ old('definition') }}</textarea>

						@error('definition')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="impact">Impact</label>
						<textarea class="summernote" name="impact">{{ old('impact') }}</textarea>

						@error('impact')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="todolist">Todo</label>
						<input type="text" class="form-control" name="todolist" value="{{ old('todolist') }}" />

						@error('todolist')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<h3>Options{!! $required_field_html !!}</h3>

					<div id="options_wrapper" style="margin-bottom: 20px;">

						<div class="form-group">
							<label class="control-label" style="width: 100%;">Option <span class="option_no">1</span> <a class="btn btn-custom-danger btn-xs pull-right delete_option" style="display: none;"><span class="glyphicon glyphicon-trash"></span> Delete</a></label>
							<input class="form-control option_label validate[required]" name="options[]" placeholder="Option label" />
							<div class="checkbox-inline">
								<label>
									<input type="checkbox" name="is_right_answer[]" class="validate[required]" value="1" /> Is answer?
								</label>
							</div>
						</div>

						<input type="button" id="add_more_option" class="btn btn-custom-info" value="Add option" />
					</div>

					<div class="clearfix"></div>
					
					<input type="hidden" name="right_answers" id="right_answers" />
					<input type="submit" name="submit" class="btn btn-custom-primary" value="Create" />

				</form>

            </div>

        </div>

    </div>

    <div class="col-sm-2 col-xs-12"></div>

</div>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/codemirror.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/codemirror/5.41.0/mode/xml/xml.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

@endsection