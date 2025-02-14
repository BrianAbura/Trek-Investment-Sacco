<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['shareId'])) { //Incase Editing Shares
  $shareId = htmlspecialchars(( isset( $_REQUEST['shareId'] ) )?  $_REQUEST['shareId']: null);
  $shares = DB::queryFirstRow('SELECT * from shares where Id=%s', $shareId);
  $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $shares['MembershipNumber']);
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Edit Shares Record for <?php echo $member['Fullname']." - ".$member['MembershipNumber'];?></h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageShares.php" enctype="multipart/form-data">
      <input type="hidden" value="EditShares" name="sharesAction">
      <input type="hidden" value="<?php echo $shareId; ?>" name="shareID">
            <div class="box-body">
			<div class="row">

                <div class="form-group col-sm-2">
                <label for="exampleInputEmail1">Shares Purchased</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Member_Shares" name="Member_Shares" autocomplete="off" value="<?php echo number_format($shares['SharesPurchased']);?>" requred>
                </div>

                <div class="form-group col-sm-3">
                <label for="InputOccupation">Value of Share</label>
                <input type="text" class="form-control CommaAmount" id="share_value" name="share_value" autocomplete="off" requred value="<?php echo number_format($shares['ShareValue']);?>">
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Purchase Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" name="purchase_date" id="datepicker" autocomplete="off" required value="<?php echo date_format(date_create($shares['PurchaseDate']), 'd-m-Y');?>">
                </div>
                </div>
			      </div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Share Information</button>
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
      <h5 class="modal-title">Share Summary for <?php echo $member['Fullname']." - ".$MembershipNumber;?></h5>
      </div>
      <div class="modal-body">
          <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Shares Purchased</th>
              <th>Share Value</th>
              <th>Purchase Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumPurchased = 0;
          $sumValue = 0;
          $cnt = 1;
          $allShares = DB::query('SELECT * from shares where MembershipNumber=%s order by DateAdded desc', $MembershipNumber);
          foreach($allShares as $allShare){
          ?>
          <tr>
              <td cols><?php echo $cnt;?></td>
              <td><?php echo number_format($allShare['SharesPurchased']);?></td>
              <td><?php echo number_format($allShare['ShareValue']);?></td>
              <td><?php echo date_format(date_create($allShare['PurchaseDate']), 'd-m-Y');?></td>
              <td>
              <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <button title="Edit Share Record" href="#editShares" data-id="<?php echo $allShare['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <button title="Delete Record" class="btn btn-danger btn-xs" onclick="delRecord('<?php echo $allShare['Id']?>', 'shares', 'Share');">Delete</button>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumPurchased += $allShare['SharesPurchased'];
          $sumValue += ($allShare['SharesPurchased'] * $allShare['ShareValue']);
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td class="text-center">Summary:</td>
                    <td><?php echo number_format($sumPurchased);?></td>
                    <td><?php echo number_format($sumValue);?></td>
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


    //DataTables  
    $(function () {
    $('#summaryTable').DataTable({
      'ordering'    : false,
      'info'        : false,
    })
  })
</script>