<?php 
require_once('../defines/functions.php');

if($_REQUEST['MemFeeID']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['MemFeeID'] ) )?  $_REQUEST['MemFeeID']: null);
  $membershipFee = DB::queryFirstRow('SELECT * from membershipfees where Id=%s', $Id);
  $member = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $membershipFee['MembershipNumber']);
}
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title"> Edit Transaction: <?php echo $member['Fullname'];?> </h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageMemFees.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $membershipFee['Id'];?>" name="MemFeeID">
      <input type="hidden" value="EDIT" name="memFeeType">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Amount" name="Amount" value="<?php echo number_format($membershipFee['Amount'])?>" requred>
                </div>

                <div class="form-group col-sm-4">
                <label for="SelectMem">Narration</label>
                <select class="form-control" name="Narration" id="Narration2" >
                <option><?php echo $membershipFee['Narration']?></option>
                <option value="Membership Fees">Membership Fees</option>
                <option value="Annual">Annual Subscription</option>
                </select>
                </div>

                <div class="form-group col-sm-3" id="subscription_year_tab2">
                <label for="datepicker">Subscription Year</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="subscription_year2" name="subscription_year" autocomplete="off">
                </div>
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Payment Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="transaction_date" id="" autocomplete="off" value="<?php echo date_format(date_create($membershipFee['DateAdded']), 'd-m-Y');?>" required>
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


      //NarrationYear
   $(function () {
    //Date picker
    $('#subscription_year2').datepicker({
      autoclose: true,
	  minViewMode: 2,
	  format: "yyyy",
	  minDate: new Date(),
    })

  })
</script>

<script>
  var Narration = document.getElementById("Narration2");
  var subscription_year_tab = document.getElementById("subscription_year_tab2");

  subscription_year_tab.style.display = "none";

  Narration.onchange = function(){
  if(Narration.value == "Annual"){
    subscription_year_tab.style.display = "block";
  }
  else{
    subscription_year_tab.style.display = "none";
  }
}
</script>