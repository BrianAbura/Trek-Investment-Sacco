<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

if($_REQUEST['LoanID']) {
    $LoanID = htmlspecialchars(( isset( $_REQUEST['LoanID'] ) )?  $_REQUEST['LoanID']: null);
   
    $loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $LoanID);
    $member = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $loan['MembershipNumber']);
 }
?>
     <div class="modal-header bg-blue color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Loan Summary: #<?php echo $LoanID." - ".$member['Fullname'];?></h5>
      </div>
      <div class="modal-body table-responsive">
            
      <div class="row">
        <div class="form-group col-sm-2">
        <label for="InputAmount">Date Requested</label>
        <h5><?php echo date_format(date_create($loan['DateCreated']), 'd-M-Y');?></h5>
        </div>

        <div class="form-group col-sm-2">
        <label for="InputAmount">Loan Amount</label>
        <h5><?php echo number_format($loan['Principal']);?></h5>
        </div>

        <div class="form-group col-sm-2">
        <label for="InputAmount" title="Opening Interest Rate">Rate</label>
        <h5><?php echo $loan['Rate'];?>%</h5>
        </div>

        <div class="form-group col-sm-2">
        <label for="InputAmount">Interest</label>
        <h5><?php echo number_format($loan['Interest']);?></h5>
        </div>

        <div class="form-group col-sm-2">
        <label for="InputAmount">Total Amount</label>
        <h5><?php echo number_format($loan['TotalAmount']);?></h5>
        </div>
      </div>

       <hr/>

       <table class="table table-bordered small">
        <caption style="text-align:left; font-size:14px; font-weight:bold; color:darkblue">
        Review Progress
        </caption>
                <thead>
                <tr>
                  <th>#</th>
                  <th>Status</th>
                  <th>Reviewer</th>
                  <th>Comments</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                
				<?php 
                $cnt = 1;
                $approvals = DB::query('SELECT * from loanapprovals where LoanId=%s order by Id desc', $LoanID);
                foreach($approvals as $approval){
                  if($approval['Status'] == "APPROVED" || $approval['Status'] == "COMPLETED"){
                    echo "<tr class='success'>";
                  }
                  else if($approval['Status'] == "REJECTED"){
                    echo "<tr class='danger'>";
                  }
                  
               ?>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $approval['Status'];?></td>
                  <td><?php echo $approval['ReviewBy'];?></td>
                  <td><?php echo $approval['Narration'];?></td>
                  <td><?php echo date_format(date_create($approval['Date']), 'd-m-Y H:i:s');?></td>
                </tr>
                <?php 
                $cnt++;
                } 
				?>
				</tbody>
			</table>
      <hr/>

       <table class="table table-bordered table-striped small">
        <caption style="text-align:left; font-size:14px; font-weight:bold; color:#009900">
        Loan Activity
        </caption>
                <thead>
                <tr>
                  <th>Opening Balance</th>
                  <th>Amount</th>
                  <th>Closing Balance</th>
                  <th>Description</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
				<?php 
                $actions = DB::query('SELECT * from loanhistory where LoanId=%s', $LoanID);
                $openingBal = $loan['TotalAmount'];
                $closingBal = $loan['TotalAmount'];
                foreach($actions as $action){
                    
                    if($action['TransactionType'] == "Loan Request" || $action['TransactionType'] == "Loan Approved")
                    {
                        $openingBal = 0;
                    }
                    if($action['TransactionType'] == "Interest Earned"){
                        $closingBal = $closingBal + $action['Amount'];
                    }
                    elseif($action['TransactionType'] == "Loan Payment"){
                        $closingBal = $closingBal - $action['Amount'];
                    }
               ?>
                  <td><?php echo number_format($openingBal);?></td>
                  <td><?php echo number_format($action['Amount']);?></td>
                  <td><?php echo number_format($closingBal);?></td>
                  <td><?php echo $action['TransactionType'];?></td>
                  <td><?php echo date_format(date_create($action['DateAdded']), 'd-M-Y');?></td>
                </tr>
                <?php 
                $openingBal = $closingBal;
                } 
				?>
				</tbody>
			</table>
        </div>
  
        <script>
$(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});
</script>