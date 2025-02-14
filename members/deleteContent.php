<?php 
require_once('../defines.php');
require_once('../validate.php');

$RowId = ( isset( $_REQUEST['RowId'] ) )?  $_REQUEST['RowId']: null;
$Table = ( isset( $_REQUEST['Table'] ) )?  $_REQUEST['Table']: null;

if($Table == "loanrequests"){
	//Only delete records that have status=PENDING APPROVAL
	$Query = DB::queryFirstRow('SELECT * from loanrequests where Id=%s',$RowId);
	if($Query['Status'] != "PENDING APPROVAL"){
		 echo "Error! You do not have permission to delete this record.";
	}
	else{
		DB::update('loanrequests',array("Status"=>"DELETED"),'LoanId=%s',$Query['LoanId']);
		DB::update('guarantors',array("Status"=>"Deleted"),'LoanId=%s',$Query['LoanId']);
		echo "Your Loan request record has been deleted.";
	}
}
?>