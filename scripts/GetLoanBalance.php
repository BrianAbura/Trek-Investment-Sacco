<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$MembershipNumber = ( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null;
$LoanType = ( isset( $_REQUEST['LoanType'] ) )?  $_REQUEST['LoanType']: null;


$Loan = DB::queryFirstRow("Select Balance from loanrequests where MembershipNumber=%s AND LoanType=%s AND Status=%s", $MembershipNumber, $LoanType, "OUTSTANDING");
if($Loan){
    echo $Loan['Balance'];
}
?>