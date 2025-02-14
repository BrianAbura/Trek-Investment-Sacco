<?php 
require_once('../defines/functions.php');

if($_REQUEST['RefundsID']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['RefundsID'] ) )?  $_REQUEST['RefundsID']: null);
  $refund = DB::queryFirstRow('SELECT * from refunds where Id=%s', $Id);
}
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title"> Edit Refund</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageRefunds.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $refund['Id'];?>" name="RefundsID">
      <input type="hidden" value="EDIT" name="refundType">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Amount" name="Amount" value="<?php echo number_format($refund['Amount'])?>" requred>
                </div>

                <div class="form-group col-sm-5">
                <label for="InputOccupation">Narration</label>
                <input type="text" class="form-control" id="Narration" name="Narration" value="<?php echo $refund['Narration']?>" requred>
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Transaction Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="transaction_date" id="datepicker" autocomplete="off" value="<?php echo date_format(date_create($refund['TransactionDate']), 'd-m-Y');?>" required>
                </div>
                </div>
			</div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Record</button>
              </div>
            </form> 
      </div>
      <!--Comma On Amounts -->

<script>
$('.CommaAmount').keyup(function(event) {
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});

$(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })
</script>