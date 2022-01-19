@extends('layouts.admin')

@section('page_title')
Risk Assignment Acknowledgment
@endsection

@section('content')

<link rel="stylesheet" href="{{ asset('public/lib/datepickr/jquery-ui.css') }}" />
<script src="{{ asset('public/lib/datepickr/jquery-1.9.1.js') }}"></script>
<script src="{{ asset('public/lib/datepickr/jquery-ui.js') }}"></script>

<x-alert />

<div class="row">

    <div class="col-sm-12 col-xs-12">

        <div class="panel panel-default panel-custom">

            <div class="panel-heading">

                <div class="row">

                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-certificate" aria-hidden="true"></i> Risk Assignment Acknowledgment</h3>
                    </div>

                </div>

            </div>

            <div class="panel-body">

                <div class="table-responsive">

                    <table id="tbl_training_acknowledgements" class="table table-striped table-bordered table-hover" style="width: 100%;">

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>HIPPA Compliance Officer</th>
                                <th>Compliance Date</th>
                                <th>Employee Acknowledgement</th>
                                <th>Acknowledgement Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>

                    </table>

                </div>

                <form class="validateForm" method="POST" action="{{ route('risk.ack.store') }}">

                    @csrf

                    <h3><b>APPROVED</b></h3>
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <tr class="odd gradeX">
                                <td style="width: 50%;">
                                    <b>HIPPA Compliance Officer:</b> <input type="text" name="compliance_officer" class="validate[required, maxSize[255]]" />
                                </td>
                                <td style="width: 50%;">
                                    <b>Date: </b> <input type="text"  name="compliance_date" class="datepicker validate[required, custom[date]]" autocomplete="off"  placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" />
                                </td>
                            </tr>
                        </table>

                    </div>

                    <h3><b>RISK ASSESSMENT ACKNOWLEDGEMENT HISTORY</b></h3>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <tr class="odd gradeX">
                                <td style="width: 50%;">
                                    <b>Employee Acknowledgement:</b> <input type="text" name="acknowledgement_by" class="validate[required, maxSize[255]]" />
                                </td>
                                <td style="width: 50%;">
                                    <b>Acknowledgement Date: </b> <input type="text"  name="acknowledgement_date" class="datepicker validate[required, custom[date]]" autocomplete="off" style="width:35%" placeholder="{{ config('app.DATE_FORMAT_PLACEHOLDER') }}" />
                                </td>
                            </tr>
                        </table>
                    </div>

                    <input type="submit" name="submit" class="btn btn-custom-primary pull-right" value="Submit" />
                </form>


            </div>

        </div>

    </div>

</div>

<script>
    $(document).ready(function() {

        var tbl_user = $('#tbl_training_acknowledgements').DataTable({
            "processing": true,
            "serverSide": true,
            // "aaSorting": [[5, "desc"]],
            "oLanguage": {
                "sEmptyTable": 'Sorry! No results found.'
            },
            "language": {
                processing: '<i class="fa fa-refresh fa-spin fa-3x fa-fw text-success" style="opacity: 0.6;"></i><span class="sr-only"></span>',
                paginate: {
                    next: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
                }
            },
            "pagingType": "full_numbers",
            ajax: {
                url: '{{ route("ajax_get_risk_assignment_acknowledgements") }}',
                type: 'GET',
            },
            "columns": [
                {"data": null},
                {"data": null},
                {"data": null},
                {"data": null},
                {"data": null},
                {"data": null, "orderable": false},
            ],
            "columnDefs": [
                {
                    'targets': 0,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return data.no;
                    }
                },
                {
                    'targets': 1,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return data.compliance_officer;
                    }
                },
                {
                    'targets': 2,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return data.compliance_date;
                    }
                },
                {
                    'targets': 3,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return data.acknowledgement_by;
                    }
                },
                {
                    'targets': 4,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta) {
                        return data.acknowledgement_date;
                    }
                },
                {
                    'targets': 5,
                    'className': 'dt-body-center actions',
                    'render': function (data, type, full, meta) {
                        return data.actions;
                    }
                },
            ],
            "fnRowCallback": function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                
            }
        });

        $(document).on('click', '.delete-user', function(e) {
            e.preventDefault();

            do_confirmation_before_delete('POST', $(this).attr('href'));

            return false;
        });

    });
</script>

@endsection