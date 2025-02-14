<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['MembershipNumber'])) {
  $MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
  $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
?>
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Savings Summary for <?php echo $member['Fullname']." - ".$MembershipNumber;?></h5>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Amount</th>
              <th>Saving Mode</th>
              <th>Narration</th>
              <th>Receipt Number</th>
              <th>Receipt</th>
              <th>Savings Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumSaving = 0;
          $cnt = 1;
          $allSavings = DB::query('SELECT * from savings where MembershipNumber=%s order by DateCreated desc', $MembershipNumber);
          foreach($allSavings as $allSaving){
          ?>
          <tr>
              <td><?php echo $cnt;?></td>
              <td class="text-right"><?php echo number_format($allSaving['Amount']);?></td>
              <td><?php echo $allSaving['SavingMode'];?></td>  
              <td><?php echo $allSaving['Narration'];?></td>  
              <td><?php echo $allSaving['ReceiptNumber'];?></td>
              <td>
                  <?php 
                    if($allSaving['ReceiptImage'] != NULL){
                  ?>
                    <a href="#" class="pop">
                    <img class="img-responsive borderImg" src="<?php echo $allSaving['ReceiptImage'];?>" width="30" height="50">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td>  
                
                
                
                <td><?php echo date_format(date_create($allSaving['SavingDate']), 'd-m-Y');?></td> 
              <td>
              <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <a title="Edit Savings Record" href="savings_edit.php?SavingsId=<?php echo $allSaving['SavingsId']?>" class="btn btn-primary btn-xs">EDIT</a>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumSaving += $allSaving['Amount'];
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td class="text-left">Total Savings:</td>
                    <td colspan="1" class="text-right"><?php echo number_format($sumSaving);?></td>
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

$(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
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