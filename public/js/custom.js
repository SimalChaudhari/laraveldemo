// function generateFormAndSubmit(method, action_url) {
function do_confirmation_before_delete(method, action_url) {

	BootstrapDialog.show({
		title: 'Delete',
		type: 'type-danger',
		message: 'Are you sure you want to delete?',
		hotkey: 13, // Enter.
		closeByBackdrop: false,
		closeByKeyboard: true,
		buttons: [{
			label: 'No',
			id: 'btn_dont_delete',
			cssClass: 'btn-custom-danger',
			action: function (dialogItself) {
				dialogItself.close();
			}
		}, {
			label: 'Yes',
			cssClass: 'btn-custom-success',
			action: function(dialogItself) {

				$('#btn_dont_delete').prop('disabled', true);
				
				var $button = this;

				$button.disable();
				$button.spin();

				generateFormAndSubmit(method, action_url);

			}
		}],
	});
}

function generateFormAndSubmit(method, action_url) {
	var form = '<form id="actionForm" method="' + method + '" action="' + action_url + '">';
			form += '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" />';
		form += '</form>';

	$('body').append(form);
	$('form#actionForm').submit();
}

function reset_option_number() {
	var i = 1;
	$('#options_wrapper').find('.form-group').each(function() {
		$(this).find('.option_no').text(i++);
	});
}

function getDocumentModal() {
	var modal = '<div class="modal fade" id="viewDocument" tabindex="-1" role="dialog" aria-labelledby="viewDocumentLabel" data-backdrop="static">';
		modal += '<div class="modal-dialog modal-lg" role="document">';
			modal += '<div class="modal-content">';
				modal += '<div class="modal-header">';
					modal += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
					modal += '<h4 class="modal-title" id="viewDocumentLabel">View Document</h4>';
				modal += '</div>';

				modal += '<div class="modal-body">';
					modal += '<div class="row">';
						modal += '<div class="embed-responsive embed-responsive-4by3">';
							modal += '<iframe id="documentURL" src="" class="embed-responsive-item" frameborder="0"></iframe>';
						modal += '</div>';
					modal += '</div>';
				modal += '</div>';
				
			modal += '</div>';
		modal += '</div>';
	modal += '</div>';

	return modal;
}

$(document).ready(function(e) {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	if( $('.datepicker').length > 0 ) {
		$(".datepicker").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "1960:2050",
			dateFormat: site.dateFormat
		});
	}

	if( $('.summernote').length > 0 ) {
		$('.summernote').summernote({
			height: 300,
			codemirror: { // codemirror options
				theme: 'monokai'
			},
			toolbar: [
				[ 'style', [ 'style' ] ],
				[ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
				[ 'fontname', [ 'fontname' ] ],
				[ 'fontsize', [ 'fontsize' ] ],
				[ 'color', [ 'color' ] ],
				[ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
				[ 'table', [ 'table' ] ],
				[ 'insert', [ 'link'] ],
				[ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
			]
		});
	}

	$(document).on('click', '.view-document', function(e) {
		e.preventDefault();

		$('body').append(getDocumentModal());

		var src = $(this).attr('href');

		$('iframe#documentURL').attr('src', src);
		$('#viewDocument').modal('show');
	});

	$(document).on('click', '#add_more_option', function(e){
		e.preventDefault();

		$('#options_wrapper').find('.form-group:first').find('.delete_option').show();

		var option = $('#options_wrapper').find('.form-group:first').clone();

		// show delete button on first
		// $('#options_wrapper').find('.form-group:first').find('.delete_option').show();


		// reset text, checkbox, button value
		$(option).find('input[type="checkbox"]').prop('checked', false);

		$('#options_wrapper .form-group:last').after( option );
		// reset textbox value
		$('#options_wrapper .option_label:last').val('');

		reset_option_number();

	});

	$(document).on('click', '.delete_option', function(e) {
		e.preventDefault();

		$(this).parents().closest('.form-group').remove();
		if( $('#options_wrapper .form-group').length == 1 ) {
			$('.delete_option').hide();
		}

		reset_option_number();
	});

	$(document).on('change', 'input[type="checkbox"]', function() {
		var ary_answers = [];
		$('#options_wrapper').find('.form-group').each(function() {
			ary_answers.push($(this).find('input[type="checkbox"]').is(':checked'));
		});
		
		$('#right_answers').val( ary_answers.join(',') );
	});

	var signature_fields = [
		'covered_entity_signature_pad',
		'business_associate_signature_pad'
	];

	signature_fields.forEach(function( div_selector_id ) {
		if( $( '#' + div_selector_id ).length > 0 ) {
			$( '#' + div_selector_id ).jSignature({
				'lineWidth': 1,
				'width': '100%',
				'height': '200px',
				'decor-color': 'transparent',
			})/*.bind('change', function(e) {
				alert('12');
			})*/;
		}
	});

	if( $( '#patient_signature_pad' ).length > 0 ) {
		$( '#patient_signature_pad' ).jSignature({
			'lineWidth': 1,
		});
	}

	if( $( '#authorize_signature_pad' ).length > 0 ) {
		$( '#authorize_signature_pad' ).jSignature({
			'lineWidth': 1,
		});
	}

	$(document).on('show.bs.modal', '#submitAcknowledgementModal', function() {
		$( '#employee_signature' ).jSignature({
			'lineWidth': 1,
			'width': '800',
			'height': '150',
			// 'decor-color': 'transparent',
		});

	});

	$(document).on('click', '#reset_employee_signature', function(e) {
		e.preventDefault();
		$('#employee_signature').jSignature('reset');
	});

	$(document).on('click', '#submit_employee_training_acknowledgement_form', function(e) {

		e.preventDefault();

		var emp_signature = $( '#employee_signature' ).jSignature('getData', 'svgbase64');

		if( ! $('#formEmployeeTrainingAcknowledgement').validationEngine('validate') ) {
			return false;
		}

		if( emp_signature[1] == '' ) {
			return false;
		}

		$('#submit_employee_training_acknowledgement_form').html('Processing&nbsp;<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

		var data = $('#formEmployeeTrainingAcknowledgement').serializeArray();
		
		data.push({ 'name': 'signature', 'value': emp_signature.join(',') });

		var redirect_url = $(this).data('redirect_url');
		var acknowledgement_submit_url = $(this).data('submit_url');

		$.ajax({
			url: acknowledgement_submit_url,
			method: 'POST',
			data: data,
			success: function(response) {
				window.location.href = redirect_url;
			}
		});

	});


	$(document).on('click', '.clear_signature_pad', function(e) {
		e.preventDefault();
		$('#' + $(this).data('signature_div_id')).jSignature('reset');

		if ( $('#patient_signature_by').length > 0 ) {
			$('#patient_signature_by').val('');
		}

	});

	$(document).on('change', 'form', function() {

		if( $('#covered_entity_signature_pad').length > 0 ) {

			var signature_pad_img_str = $('#covered_entity_signature_pad').jSignature("getData", "base30");
			if( signature_pad_img_str[1] != '' ) {
				$('#covered_entity_signature_base').val( signature_pad_img_str.join(",") );
			}

			var signature_pad_img_str = $('#covered_entity_signature_pad').jSignature("getData", "svgbase64");
			if( signature_pad_img_str[1] != '' ) {
				$('#covered_entity_signature_svg').val( signature_pad_img_str.join(",") );
			}

		}

		if( $('#business_associate_signature_pad').length > 0 ) {

			var signature_pad_img_str = $('#business_associate_signature_pad').jSignature("getData", "base30");
			if( signature_pad_img_str[1] != '' ) {
				$('#business_associate_signature_base').val( signature_pad_img_str.join(",") );
			}

			var signature_pad_img_str = $('#business_associate_signature_pad').jSignature("getData", "svgbase64");
			if( signature_pad_img_str[1] != '' ) {
				$('#business_associate_signature_svg').val( signature_pad_img_str.join(",") );
			}
			
		}

		if( $('#patient_signature_pad').length > 0 ) {

			var signature_pad_img_str = $('#patient_signature_pad').jSignature("getData", "base30");
			if( signature_pad_img_str[1] != '' ) {
				$('#patient_signature_base').val( signature_pad_img_str.join(",") );
			}

			var signature_pad_img_str = $('#patient_signature_pad').jSignature("getData", "svgbase64");
			if( signature_pad_img_str[1] != '' ) {
				$('#patient_signature_svg').val( signature_pad_img_str.join(",") );
			}
			
		}

		if( $('#authorize_signature_pad').length > 0 ) {

			var signature_pad_img_str = $('#authorize_signature_pad').jSignature("getData", "base30");
			if( signature_pad_img_str[1] != '' ) {
				$('#authorize_signature_base').val( signature_pad_img_str.join(",") );
			}

			var signature_pad_img_str = $('#authorize_signature_pad').jSignature("getData", "svgbase64");
			if( signature_pad_img_str[1] != '' ) {
				$('#authorize_signature_svg').val( signature_pad_img_str.join(",") );
			}
			
		}

	});

	if( $('#covered_entity_signature_base').length > 0 ) {

		var sign_30 = $('#covered_entity_signature_base').val();
		if (sign_30 && sign_30 != "image/jsignature;base30,") {
        	$('#covered_entity_signature_pad').jSignature("setData", "data:" + sign_30);
        }



	}

	if( $('#business_associate_signature_base').length > 0 ) {

		var sign_30 = $('#business_associate_signature_base').val();
		if (sign_30 && sign_30 != "image/jsignature;base30,") {
        	$('#business_associate_signature_pad').jSignature("setData", "data:" + sign_30);
        }

    }

    if( $('#patient_signature_base').length > 0 ) {

		var sign_30 = $('#patient_signature_base').val();
		if (sign_30) {
        	$('#patient_signature_pad').jSignature("setData", "data:" + sign_30);
        }

    }

    if( $('#authorize_signature_base').length > 0 ) {

		var sign_30 = $('#authorize_signature_base').val();
		if (sign_30) {
        	$('#authorize_signature_pad').jSignature("setData", "data:" + sign_30);
        }

    }

    if( $('form.validateForm').length > 0 ) {
    	$('form.validateForm').validationEngine({
    		notEmpty: true, // validate field only when there is wrong input entered
    	});
    }

});