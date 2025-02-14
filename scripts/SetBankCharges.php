<?php
if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
//Monthly Expenses
/** Every 25th of the month */
require_once('/var/www/trekinvestment.com/defines/functions.php');
$log = new Logger(LOG_FILE,Logger::DEBUG);

$curDate = date('Y-m-d');

		//Ledger Fee
$MaintenanceFee = array(
	'Amount'=>'4000',
	'Narration'=>'Account Maintenance Fee',
	'TransactionDate'=>$curDate,
	'AddedBy'=>'SYS_AUTO',
	);
DB::insert('expenses', $MaintenanceFee);
$log->LogInfo("Monthly Account Maintenance Information: ".print_r('Successful Logged',true));

//Excise Duty
$ExciseButy = array(
	'Amount'=>'600',
	'Narration'=>'Excise Duty',
	'TransactionDate'=>$curDate,
	'AddedBy'=>'SYS_AUTO',
	);
DB::insert('expenses', $ExciseButy);
$log->LogInfo("Monthly Excise Duty Information: ".print_r('Successful Logged',true));
?>
