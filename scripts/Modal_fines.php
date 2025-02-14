<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['fineId'])) {
  $Id = htmlspecialchars(( isset( $_REQUEST['fineId'] ) )?  $_REQUEST['fineId']: null);
  $fine = DB::queryFirstRow('SELECT * from fines where Id=%s', $Id);
  $member = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $fine['MembershipNumber']);
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title"> <?php echo "Edit ".$member['Fullname']."'s Fines" ?> </h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageFines.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $fine['Id'];?>" name="editFineID">
      <input type="hidden" value="EDIT" name="adminFeeAction">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount Fined</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Amount" name="Amount" value="<?php echo number_format($fine['Amount'])?>" requred>
                </div>

                <div class="form-group col-sm-5">
                <label for="InputOccupation">Narration</label>
                <input type="text" class="form-control" id="Narration" name="Narration" value="<?php echo $fine['Narration']?>" requred>
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Transaction Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="transaction_date" id="datepicker" autocomplete="off" value="<?php echo date_format(date_create($fine['TransactionDate']), 'd-m-Y');?>" required>
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
<?php 
}
if(isset($_REQUEST['MembershipNumber'])) {
  $MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
  $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
?>

<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Fines Summary for <?php echo $member['Fullname']." - ".$MembershipNumber;?></h5>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Amount Fined</th>
              <th>Narration</th>
              <th>Transaction Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumFines = 0;
          $cnt = 1;
          $allFines = DB::query('SELECT * from fines where MembershipNumber=%s order by DateAdded desc', $MembershipNumber);
          foreach($allFines as $allFine){
          ?>
          <tr>
              <td><?php echo $cnt;?></td>
              <td class="text-right"><?php echo number_format($allFine['Amount']);?></td>
              <td><?php echo $allFine['Narration'];?></td>  
              <td><?php echo date_format(date_create($allFine['TransactionDate']), 'd-m-Y');?></td> 
              <td>
              <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <button title="Edit Fine Record" href="#editFines" data-id="<?php echo $allFine['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumFines += $allFine['Amount'];
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td class="text-center">Total Fines:</td>
                    <td class="text-right"><?php echo number_format($sumFines);?></td>
                    </tr>
                </tfoot>
        </table>

      </div>
<?php 
}
?>
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