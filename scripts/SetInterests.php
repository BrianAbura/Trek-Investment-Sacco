<?php 
//This Script, sets the interests for the different members. SMS's also go in that regard

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
require_once('/var/www/trekinvestment.com/defines/functions.php');

$log = new Logger(LOG_FILE,Logger::DEBUG);

$curDate = date('Y-m-d H:i:s');

$weekDate = date('Y-m-d H:i:s', strtotime($curDate. ' + 1 week'));
//$log->LogInfo("Test Log at:  ".print_r($curDate,true));

		///Weekly Reminder on Loan Due Date.
$LoanReminder = DB::query('SELECT * from loanrequests where DueDate<=%s AND Status=%s',$weekDate, 'OUTSTANDING');
foreach($LoanReminder as $Loan){
	$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s',$Loan['MembershipNumber']);
	$TableId = "LR - ".$Loan['Id'];
	
		//Weekly Reminder.
		if($Loan['WeekSMS'] != 'SENT'){
			$SMS = "Your TREK loan of UGX".number_format($Loan['Balance'])." is due on ".date('d-m-Y', strtotime($Loan['DueDate']));
			SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");
			DB::update('loanrequests',array('WeekSMS'=>'SENT'),'LoanId=%s',$Loan['LoanId']);
			$log->LogInfo("Weekly SMS Reminder: Loan ID ".print_r($Loan['LoanId'],true));
		}
}

		///Loan Overdue Checks
$Loans = DB::query('SELECT * from loanrequests where DueDate<=%s AND Status=%s',$curDate, 'OUTSTANDING');
foreach($Loans as $Loan){
			$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s',$Loan['MembershipNumber']);
		//On Due Date
		//Enforce 10% on the Periods exceeding current
			$interval = date_diff(date_create($Loan['DateCreated']), date_create($curDate));
			$interval = ($interval->format('%y')*12) + $interval->format('%m');
			if($interval > $Loan['LoanPeriod'])
			{
			$Rate = 10;
			}
			else{
			$Rate = $Loan['Rate'];
			}
		//1.Update the Loan Balance and DueDate
			$NewDuedate = date('Y-m-d H:i:s', strtotime($Loan['DueDate']. ' + 1 months'));
			$NewInterest = round(($Rate/100)*$Loan['Balance']);
			$NewBalance = $Loan['Balance'] + $NewInterest;
			
			$UpdateLoan = array(
			'Balance'=>$NewBalance,
			'DueDate'=>$NewDuedate,
			'Rate'=>$Rate,
			'WeekSMS'=>'',
			);
			DB::update('loanrequests',$UpdateLoan,'LoanId=%s',$Loan['LoanId']);
			
			$SMS = "Your TREK loan is overdue. New Loan Balance is UGX".number_format($NewBalance)." and new due date is ".date('d-m-Y', strtotime($NewDuedate));
			SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");
			
			$log->LogInfo("Loan Request Updated: Loan ID ".print_r($Loan['LoanId'],true));
			
			//Add Interests
			$Interests = array(
			'LoanId'=>$Loan['LoanId'],
			'MembershipNumber'=>$Loan['MembershipNumber'],
			'Amount'=>$NewInterest,
			'CreatedBy'=>'SYS_AUTO',
			);
			DB::insert('interests', $Interests);
			$log->LogInfo("Loan Interest Updated: Loan ID ".print_r($Loan['LoanId'],true));

			//Record this history
			$LoanHistory = array(
			'LoanId'=>$Loan['LoanId'],
			'TransactionType'=>'Interest Earned',
			'Amount'=>$NewInterest,
			'AddedBy'=>'SYS_AUTO',
			);
			DB::insert('loanhistory', $LoanHistory);
			$log->LogInfo("Loan History Updated: Loan ID ".print_r($Loan['LoanId'],true));
}
?>