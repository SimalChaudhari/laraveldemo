@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<script>
    $(function () {
        $("#renewal_date").datepicker({
            changeMonth: true,
            //numberOfMonths: 2,
            changeYear: true,
            yearRange: "1960:2050",
        });
        $("#emi_date").datepicker({
            changeMonth: true,
            //numberOfMonths: 2,
            changeYear: true,
            yearRange: "1960:2050",
        });
        $("#last_emi_date").datepicker({
            changeMonth: true,
            //numberOfMonths: 2,
            changeYear: true,
            yearRange: "1960:2050",
        });
        $("#payment_date").datepicker({
            changeMonth: true,
            //numberOfMonths: 2,
            changeYear: true,
            yearRange: "1960:2050",
        });
        $("#recpt_date").datepicker({
            changeMonth: true,
            //numberOfMonths: 2,
            changeYear: true,
            yearRange: "1960:2050",
        });
    });
</script>

@include('template.notification')

<h1 style="text-align: center;" >ACCOUNTING OF DISCLOSURES TRACKING SHEET</h1>

<table class="table table-bordered table-hover">

	<tr>
		<td></td>
	</tr>

</table>

<h4 style="text-align: justify;" ><b>Use this form to track all disclosures outside of Treatment, Payment and Health Care Operations (TPO) for the Patient Listed Below. Our practice must keep and be prepared to make this information available to the patient, upon their request, for a period of six (6) years.</b></h4>

<form method="POST" action="{{ route('updateADTSForm') }}">

	@csrf

	<div class="table-responsive">

		<table class="table table-bordered table-hover">

			<tr class="odd gradeX">
				<td><b>NAME OF PATIENT</b></td>
				<td colspan="3"><input type="text" name="name" required style="width:50%" /></td>
			</tr>

			<tr class="odd gradeX">
				<td><b>DATE OF BIRTH</b></td>
				<td><input type="text"  name="dob" id="last_emi_date" required style="width:98%" autocomplete="off" /></td>
				<td><b>SS#</b> </td>
				<td><input type="text" name="ss" required="reqired" style="width:98%" maxlength="9" /></td>
			</tr>

		</table>

	</div>

	<table class="table table-bordered table-hover" style="width:50%;">

		<tr>
			<td><b>DATE OF 1<sup>ST</sup> ENTRY</b></td>
			<td><input type="text"  name="first_entry" id="emi_date" required style="width:98%" autocomplete="off" /></td>
		</tr>
	</table>

	<div class="table-responsive">

		<table class="table table-bordered table-hover">

			<tr class="odd gradeX">
				<td colspan="2"><b>Data Information Was Released: </b><input type="text" name="data_info" required style="width:76%" /></td>
			</tr>

			<tr class="odd gradeX">
				<td colspan="2"><b>To whom was the information (PHI) released/disclosed: </b><input type="text" name="to_whome" required style="width:35%" /></td>
			</tr>

			<tr class="odd gradeX">
				<td colspan="2"><b>Description of the information released/discloused: </b><input type="text" name="descri_info" required style="width:62.5%" /></td>
			</tr>

			<tr class="odd gradeX">
				<td colspan="2"><b>Additional Information/Notes: </b><input type="text" name="add_info" required style="width:77.5%" /></td>
			</tr>

			<tr class="odd gradeX">
				<td><b>Reported By: </b><input type="text" name="reported_by" required style="width:50%" /></td>
				<td><b>Signature: </b><input type="text" name="sign" required style="width:50%" /></td>
			</tr>

		</table>

	</div>

	<input type="submit" name="submit" class="btn btn-primary pull-right" value="Submit" />

</form>

@endsection