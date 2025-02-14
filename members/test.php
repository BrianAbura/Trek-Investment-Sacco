<?php 
require_once('../defines/functions.php');

$loans = DB::query('SELECT * from loanrequests where Status IN %ls', ['OUTSTANDING', 'PENDING APPROVAL', 'APPROVED']);
foreach($loans as $loan){
  $guarantors = DB::query('SELECT * from guarantors where LoanId=%s AND Status=%s AND LoanStatus=%s AND MembershipNumber !=%s', $loan['LoanId'], 'Accepted', 'OUTSTANDING', $loan['MembershipNumber']);
  $num = DB::count();
  $payments = DB::queryFirstRow('SELECT sum(AmountPaid) as paid_loan from loanpayments where LoanId=%s', $loan['LoanId']);

  $dist = floor($payments['paid_loan']/$num);


  foreach($guarantors as $guarantor){
    echo $loan['LoanId']." - ".$guarantor['MembershipNumber']." guranteed ".$guarantor['Amount']."<br/>";
    if($dist >= $guarantor['Amount'] ){
      DB::update('guarantors', array('AmountPaid' => $guarantor['Amount']), 'Id=%s', $guarantor['Id']);
    }
    else{
      DB::update('guarantors', array('AmountPaid' => $dist), 'Id=%s', $guarantor['Id']);
    }
  }
  
  //DB::update('guarantors', array('AmountPaid' => $dist), 'LoanId=%s', $loan['LoanId']);

  echo "Loan Distribution ".$loan['LoanId']." - ".$num." - ".($dist)."<br/>";

  foreach($guarantors as $guarantor){
    echo $guarantor['MembershipNumber']." | ".$guarantor['AmountPaid']."<br/>";
  }
}
