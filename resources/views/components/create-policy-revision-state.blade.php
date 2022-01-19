<h2>Add new Revision</h2>
<form method="POST" action="{{ route('savePolicyRevisionState') }}">

    @csrf

    <h3><b>APPROVED</b></h3>
    <div class="table-responsive">

        <table class="table table-bordered table-hover">
            <tr class="odd gradeX">
                <td>
                    <b>HIPPA Compliance Officer:</b> <input type="text" name="comp_ofc" maxlength="255" required style="width:35%" />
                </td>
                <td>
                    <b>Date: </b> <input type="text"  name="comp_date" id="recpt_date" class="datepicker" required style="width:35%" />
                </td>
            </tr>
        </table>

    </div>

    <h3><b>REVISION HISTORY</b></h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <tr class="odd gradeX">
                <td>
                    <b>Revision Date: </b> <input type="text"  name="revision_date" id="payment_date" class="datepicker" required style="width:35%" />
                </td>
                <td>
                    <b>Revision: </b> <input type="text" name="revision" required style="width:35%" maxlength="255" />
                </td>
                <td>
                    <b>Revision Made By: </b> <input type="text" name="revision_by" required style="width:35%" maxlength="255" />
                </td>
            </tr>
        </table>
    </div>

    <input type="hidden" name="type" value="{{ $type }}" />
    <input type="hidden" name="parent_id" value="{{ $parentId }}" />
    
    <input type="submit" name="submit" class="btn btn-custom-primary pull-right" value="Submit" />

</form>