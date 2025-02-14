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
      <h5 class="modal-title">Loan Payments Summary for <?php echo $member['Fullname']." - ".$MembershipNumber;?></h5>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Loan ID</th>
              <th>Loan Type</th>
              <th>Loan Amount</th>
              <th>Installment Paid</th>
              <th>Current Balance</th>
              <th>Payment Mode</th>
              <th>Receipt Number</th>
              <th>Payment Receipt</th>
              <th>Payment Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumLoanPayments = 0;
          $cnt = 1;
          $allLoanPayments = DB::query('SELECT * from loanpayments where MembershipNumber=%s order by DateAdded desc', $MembershipNumber);
          foreach($allLoanPayments as $allLoanPayment){
          ?>
          <tr>
              <td><?php echo $cnt;?></td>
              <td><?php echo $allLoanPayment['LoanId'];?></td> 
              <td><?php echo $allLoanPayment['LoanType'];?></td> 
              <td class="text-right"><?php echo number_format($allLoanPayment['TotalAmount']);?></td>
              <td class="text-right"><?php echo number_format($allLoanPayment['AmountPaid']);?></td>
              <td class="text-right"><?php echo number_format($allLoanPayment['Balance']);?></td>
              <td><?php echo $allLoanPayment['PaymentMode'];?></td>   
              <td><?php echo $allLoanPayment['ReceiptNumber'];?></td>
              <td>
                  <?php 
                    if($allLoanPayment['PaymentReceipts'] != NULL){
                  ?>
                    <a href="#" class="pop">
                    <img class="img-responsive borderImg" src="<?php echo $allLoanPayment['PaymentReceipts'];?>" width="30" height="50">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td> 
                <td><?php echo date_format(date_create($allLoanPayment['PaymentDate']), 'd-m-Y');?></td> 
              <td>
              <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <a title="Edit Loan Payment Record" href="loanPayments_edit.php?loanPaymentId=<?php echo $allLoanPayment['Id']?>" class="btn btn-primary btn-xs">EDIT</a>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumLoanPayments += $allLoanPayment['AmountPaid'];
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td colspan="2" class="text-left">Total Amount Paid in Loans:</td>
                    <td colspan="1" class="text-right"><?php echo number_format($sumLoanPayments);?></td>
                    </tr>
                </tfoot>
        </table>

      </div>

<?php } ?>

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