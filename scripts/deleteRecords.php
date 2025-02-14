<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$RowId = ( isset( $_REQUEST['RowId'] ) )?  $_REQUEST['RowId']: null;
$Table = ( isset( $_REQUEST['Table'] ) )?  $_REQUEST['Table']: null;
$Ctype = ( isset( $_REQUEST['Ctype'] ) )?  $_REQUEST['Ctype']: null; #Content Type

if($Table == "loanrequests"){
	//Only delete records that have status=PENDING APPROVAL
	$Query = DB::queryFirstRow('SELECT * from loanrequests where Id=%s',$RowId);
	$LoanId = $Query['LoanId'];
	if($Query['Status'] != "PENDING APPROVAL"){
		 echo "Error! Active Loan record cannot be deleted.";
	}
	else{
		#Three Main First
		DB::delete('loanapprovals', 'LoanId=%s', $LoanId); #LoanApprovals
		DB::delete('loanhistory', 'LoanId=%s', $LoanId); #LoanHistory
		DB::delete('guarantors', 'LoanId=%s', $LoanId); #Guarantors
		#Then the table
		DB::delete($Table, 'Id=%s', $RowId); #Loan Request
		#Message
		echo $Ctype." Record has been deleted together with its associated approvals and guarantor requests.";
	}
}
else{
	DB::delete($Table, 'Id=%s', $RowId);
	echo $Ctype." Record has been deleted";
}
?>