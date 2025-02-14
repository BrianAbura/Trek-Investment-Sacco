<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);
$ReviewId = $_SESSION['AccId'];

$LoanId = ( isset( $_REQUEST['LoanId'] ) )?  $_REQUEST['LoanId']: null;
$Status = ( isset( $_REQUEST['Status'] ) )?  $_REQUEST['Status']: null;
$Reason = ( isset( $_REQUEST['Reason'] ) )?  $_REQUEST['Reason']: null;
$dateUpdated = date('Y-m-d H:i:s');

$loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $LoanId);

if(!$loan){
	echo "This loan does not exist or has already been approved. Please contact the Administrator for assistance.";
}
else{
	$member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $loan['MembershipNumber']);
	$approval = DB::queryFirstRow('SELECT * from loanapprovals where LoanId=%s order by Id desc', $loan['LoanId']);
	//Update Approvals based on the Action
	DB::update('loanapprovals', array('ReviewBy'=>$CreatedBy, 'ReviewId'=>$ReviewId,  'Status'=>$Status, 'Narration'=>$Reason, 'Date'=>$dateUpdated), 'Id=%s', $approval['Id']);
	// Approval flow: Treasurer(3) >> Chairperson(1)-Final
	if($approval['RoleId'] == 3){ //Treasurer Level
		if($Status == "APPROVED"){
			$loanapprovals = array(
			'LoanId'=>$LoanId,
			'RoleId'=>1,
			'ReviewBy'=>"",
			'ReviewId'=>"",
			'Status'=>'Pending Final Review by Chairperson.',
			'Narration'=>""
			);
			DB::insert('loanapprovals', $loanapprovals);
			echo "You have approved ".$member['Fullname']."'s Loan of UGX".number_format($loan['Principal'])."<br/><br/><b>Comment</b>: ".$Reason."<br/><br/>Loan is Pending Final Review by Chairperson.";
		}
		else{
			$UpdateLoan = array(
			"Status"=>"REJECTED",
			"ApprovalStatus"=>"Rejected at Treasurer",
			"ApprovedBy"=>$CreatedBy,
			"ApprovalReason"=>$Reason,
			);
			DB::update('loanrequests', $UpdateLoan, 'LoanId=%s', $LoanId);

			//Update the Guarantors
			DB::update('guarantors', array('LoanStatus'=>'REJECTED'), 'LoanId=%s', $LoanId);

			//Loan History
			$LoanHistory = array(
			'LoanId'=>$LoanId,
			'TransactionType'=>'Loan Rejected',
			'Amount'=>$loan['TotalAmount'],
			'AddedBy'=>$CreatedBy,
			);
			DB::insert('loanhistory', $LoanHistory);
			echo "You have Rejected ".$member['Fullname']."'s Loan of UGX".number_format($loan['Principal'])."<br/><br/>Reason: ".$Reason;
		}
	}
	elseif($approval['RoleId'] == 1){ //Chairperson Level
		if($Status == "APPROVED"){
			DB::update('loanapprovals', array('ReviewBy'=>$CreatedBy, 'ReviewId'=>$ReviewId,  'Status'=>"COMPLETED", 'Narration'=>$Reason, 'Date'=>$dateUpdated), 'Id=%s', $approval['Id']);
			$DueDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s'). ' + 1 months'));
			$UpdateLoan = array(
			"Status"=>"OUTSTANDING",
			"DueDate"=>$DueDate,
			);
			DB::update('loanrequests', $UpdateLoan, 'LoanId=%s', $LoanId);

			//Update the Guarantors
			DB::update('guarantors', array('LoanStatus'=>'OUTSTANDING'), 'LoanId=%s', $LoanId);

			//Add Interests
			$Interests = array(
			'LoanId'=>$LoanId,
			'MembershipNumber'=>$loan['MembershipNumber'],
			'Amount'=>$loan['Interest'],
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('interests', $Interests);

			//Record this History
			$LoanHistory = array(
			'LoanId'=>$LoanId,
			'TransactionType'=>'Loan Approved',
			'Amount'=>$loan['TotalAmount'],
			'AddedBy'=>$CreatedBy,
			);
			DB::insert('loanhistory', $LoanHistory);
			echo "You have approved ".$member['Fullname']."'s Loan of UGX".number_format($loan['Principal'])."<br/><br/><b>Comment</b>: ".$Reason."<br/><br/>Loan is Pending disbursement by Treasurer.";
		}
		else{
			//Chairperson Rejects the Loan
			$loanapprovals = array( 
			'LoanId'=>$LoanId,
			'RoleId'=>3,
			'ReviewBy'=>"",
			'ReviewId'=>"",
			'Status'=>"Rejected by Chairperson. Pending Treasurer's Review.",
			'Narration'=>""
			);
			DB::insert('loanapprovals', $loanapprovals);

			$UpdateLoan = array(
			"ApprovalStatus"=>"REJECTED by Chairperson",
			"ApprovedBy"=>$CreatedBy,
			"ApprovalReason"=>$Reason,
			);
			DB::update('loanrequests', $UpdateLoan, 'LoanId=%s', $LoanId);
			echo "You have Rejected ".$member['Fullname']."'s Loan of UGX".number_format($loan['Principal'])."<br/><br/>Reason: ".$Reason."<br/><br/> Loan is pending Treasurer's action.";
		}
	}
}
?>