@if( $revisions->count() > 0 )

    <div class="table-responsive" style="border:1px solid #000; padding:1%;">

        @foreach( $revisions as $revision )

            <h3>Revision History : {{ $loop->iteration }}</h3>
            <table class="table table-bordered">
                <tr>
                    <td colspan="2" class=""><b>HIPPA Compliance Officer:</b> {{ ucfirst( $revision->comp_ofc ) }}</td>
                    <td><b>Date:</b> {{ \Carbon\Carbon::parse( $revision->comp_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                </tr>

                <tr>
                    <td><b>Revision Date:</b> {{ \Carbon\Carbon::parse( $revision->revision_date )->format( config('app.VIEW_DATE_FORMAT') ) }}</td>
                    <td><b>Revision:</b> {{ $revision->revision }}</td>
                    <td><b>Revision Made By:</b> {{ ucfirst( $revision->revision_by ) }}</td>
                </tr>
            </table>

        @endforeach

    </div>
    
@else
    <h3>No past HISTORY found. Please add new HISTORY.</h3>
@endif