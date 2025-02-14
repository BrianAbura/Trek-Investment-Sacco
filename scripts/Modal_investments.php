<?php 
require_once('../defines/functions.php');

if($_REQUEST['InvestmentId']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['InvestmentId'] ) )?  $_REQUEST['InvestmentId']: null);
  $Investment = DB::queryFirstRow('SELECT * from investments where Id=%s', $Id);
?>
<!--Edit Savings modal-->
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageInvestments.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $Investment['Id'];?>" name="investmentID">
      <input type="hidden" value="EDIT" name="investmentAction">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount Received</label>
                <input type="text" min="0" class="form-control CommaAmount" name="Amount" value="<?php echo number_format($Investment['Amount'])?>" requred>
                </div>

                <div class="form-group col-sm-4">
                <label for="InputOccupation">Narration</label>
                <input type="text" class="form-control" name="Narration" value="<?php echo $Investment['Narration']?>" requred>
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Transaction Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar" id="transaction_date"></i>
                </div>
                <input type="text" class="form-control pull-right" name="transaction_date"  autocomplete="off" value="<?php echo date_format(date_create($Investment['TransactionDate']), 'd-M-Y');?>" required>
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

      <?php } ?>

<script>
  $(function () {
    //Date picker
    $('#transaction_date').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })

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
</script>