@extends('layouts.admin')

@section('page_title')
Edit Quiz: {{ $quiz->name }}
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
						<h3 class="panel-title"><i class="fa fa-2x fa-puzzle-piece" aria-hidden="true"></i> Edit Quiz</h3>
					</div>
				</div>
        	</div>

            <div class="panel-body">

            	<p class="col-sm-12 col-xs-12 text-right" style="padding-right: 0;"><small>({!! $required_field_html !!}) fields are mandatory.</small></p>

            	<form class="validateForm" action="{{ route('quiz.update', $quiz->uuid) }}" method="POST" enctype="multipart/form-data" role="form">
					@csrf

					<div class="form-group">
						<label for="name">Name{!! $required_field_html !!}</label>
						<input type="text" class="form-control validate[required, maxSize[255]]" name="name" value="{{ $quiz->name }}" />

						@error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="description">Description{!! $required_field_html !!}</label>
						<textarea class="summernote" name="description">{{ $quiz->description }}</textarea>

						@error('description')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
						<label for="per_page_questions">Per page questions?</label>
						<select name="per_page_questions" class="form-control validate[required]">
							<option value="1" <?php echo $quiz->per_page_questions == 1 ? 'selected' : ''; ?>>1</option>
							<option value="3" <?php echo $quiz->per_page_questions == 3 ? 'selected' : ''; ?>>3</option>
							<option value="5" <?php echo $quiz->per_page_questions == 5 ? 'selected' : ''; ?>>5</option>
							<option value="10" <?php echo $quiz->per_page_questions == 10 ? 'selected' : ''; ?>>10</option>
							<option value="15" <?php echo $quiz->per_page_questions == 15 ? 'selected' : ''; ?>>15</option>
							<option value="20" <?php echo $quiz->per_page_questions == 20 ? 'selected' : ''; ?>>20</option>
						</select>
						
						@error('per_page_questions')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
					</div>

					<input type="hidden" name="show_definition" value="0" />
					<input type="hidden" name="show_impact" value="0" />
					@if( $quiz->id != 6 )
					<div class="form-group">
						<div class="checkbox">
							<label>
								
								<input type="checkbox" name="show_definition" value="1" <?php echo $quiz->show_definition == 1 ? 'checked' : ''; ?> /> Show Definition?{!! $required_field_html !!}
							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label>
								
								<input type="checkbox" name="show_impact" value="1" <?php echo $quiz->show_impact == 1 ? 'checked' : ''; ?> /> Show Impact?{!! $required_field_html !!}
							</label>
						</div>
					</div>
					@endif
					
					<input type="submit" name="update" class="btn btn-custom-primary" value="Update" />

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