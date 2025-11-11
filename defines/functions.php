<?php
#require_once('/var/www/trekinvestment.com/defines.php');
require_once('defines.php');
// $log = new Logger(LOG_FILE,Logger::DEBUG);

function CreatedBy($id)
{
	$sysUser = DB::queryFirstRow('SELECT * from systemusers where AccId=%s', $id);
	$Role = DB::queryFirstRow('SELECT Designation as Role from roles where RoleId=%s', $sysUser['Role']);
	$CreatedBy = $sysUser['Fullname'] . "{" . $Role['Role'] . "}";
	return $CreatedBy;
}

function formatNumber($num)
{
	$num = trim($num);
	$num = preg_replace('/^07/', '2567', $num);
	$num = preg_replace('/^7/', '2567', $num);
	$num = preg_replace('/^\+2567/', '2567', $num);
	$num = preg_replace('/^\+/', '', $num);
	return $num;
}

function genPassword()
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#@%";
	return substr(str_shuffle($chars), 0, 9);
}

//Functions
function CheckMembershipNumber($MembershipNumber)
{
	$query = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
	if ($query) {
		return true;
	} else {
		return false;
	}
}

function CheckEmail($EmailAddress)
{
	$query = DB::queryFirstRow('SELECT * from members where EmailAddress=%s AND AccStatus=%s', $EmailAddress, 'Active');
	if ($query) {
		return true;
	} else {
		return false;
	}
}

function CheckAdminEmail($EmailAddress)
{
	$query = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s', $EmailAddress);
	if (isset($query['Id'])) {
		return true;
	} else {
		return false;
	}
}

function PendingApprovals($Role)
{
	DB::query("SELECT * FROM loanapprovals WHERE RoleId=%s AND Status LIKE %ss", $Role, "Pending");
	$requests = DB::count();
	return $requests;
}

//Sending SMS
function SendSms($Mobile, $Message, $TableId, $CreatedBy)
{
	$data = array(
		'client_data' => array('client_id' => CLIENT_ID, 'api_username' => SMS_USER, 'api_key' => SMS_PASS),
		'message_data' => array('mobile_number' => $Mobile, 'message' => $Message)
	);
	$url = SMS_URL;
	$json_data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ch_result = curl_exec($ch);
	curl_close($ch);
	//$log->LogInfo("EGO SMS Response: ".print_r($ch_result,true));
	#var_dump($ch_result);
	DB::insert('smsnotice', array('TableId' => $TableId, 'MSISDN' => $Mobile, 'Message' => $Message, 'Response' => $ch_result, 'CreatedBy' => $CreatedBy));
}

function send_notice($Mobile, $Message)
{
	$data = array(
		'client_data' => array('client_id' => CLIENT_ID, 'api_username' => SMS_USER, 'api_key' => SMS_PASS),
		'message_data' => array('mobile_number' => $Mobile, 'message' => $Message)
	);
	$url = SMS_URL;
	$json_data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ch_result = curl_exec($ch);
	curl_close($ch);
	//$log->LogInfo("EGO SMS Response: ".print_r($ch_result,true));
	#var_dump($ch_result);
	$response = $ch_result;
	return $response;
}

//Sending SMS
function SendEmail($TableId, $Subject, $Receipient, $Message, $CreatedBy)
{
	$Name = $Receipient['Fullname'];
	$Email = $Receipient['EmailAddress'];

	$msgBody = $Message['MsgBody'];
	$msgAttachment = $Message['MsgAttachment'];

	$data = array(
		'client_data' => array('client_id' => CLIENT_ID, 'api_username' => EMAIL_USER, 'api_key' => EMAIL_PASS),
		'message_data' => array('subject' => $Subject, 'recipient_name' => $Name, 'recipient_email' => $Email, 'message' => $Message)
	);
	$url = EMAIL_URL;
	$json_data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ch_result = curl_exec($ch);
	curl_close($ch);

	DB::insert('emails', array(
		'TableId' => $TableId,
		'ReceiverName' => $Name,
		'ReceiverEmail' => $Email,
		'Subject' => $Subject,
		'Message' => $msgBody,
		'Attachments' => $msgAttachment,
		'Response' => $ch_result,
		'CreatedBy' => $CreatedBy
	));
}

function getSMSBalance()
{
	$data = array(
		'client_data' => array('client_id' => CLIENT_ID, 'api_username' => SMS_USER, 'api_key' => SMS_PASS),
		'message_data' => array('balance' => 'getBalance')
	);
	$url = SMS_URL;
	$json_data = json_encode($data);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$ch_result = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($ch_result);
	if ($response->Status == "ERROR") {
		$res = "ERROR!";
	} else {
		$res = number_format($response->Response);
	}
	print($res);
}

function genSysUserId()
{
	$AccId = mt_rand(11111, 99999);
	$query = DB::queryFirstRow('SELECT * from systemusers where AccId=%s', $AccId);
	if (!isset($query['AccId'])) {
		return $AccId;
	}
}

function genMemNum()
{
	$query = DB::queryFirstRow('SELECT Id from members order by Id desc limit 1');
	$num = $query['Id'];
	$num = str_pad($num + 1, 3, '0', STR_PAD_LEFT);
	$ID = "TRK" . $num;
	return $ID;
}
function genSavId()
{
	$SavingsId = mt_rand(1111, 9999);
	$query = DB::queryFirstRow('SELECT * from savings where SavingsId=%s', $SavingsId);
	if (isset($query['SavingsId'])) {
		$SavingsId = mt_rand(1111, 9999);
	}
	return $SavingsId;
}

function genWelfId()
{
	$WelfareId = mt_rand(1111, 9999);
	$query = DB::queryFirstRow('SELECT * from welfare where WelfareId=%s', $WelfareId);
	if (isset($query['WelfareId'])) {
		$WelfareId = mt_rand(1111, 9999);
	}
	return $WelfareId;
}

##Dashboard
function sumMembers()
{
	DB::query('SELECT * from members where AccStatus=%s', 'Active');
	return DB::count();
}
/**Savings */
function sumSavings()
{
	$sumSavings = DB::queryFirstRow('SELECT sum(Amount) as sumSavings from savings');
	return $sumSavings['sumSavings'];
}

//Interests
function Interests()
{
	$Interests = 0;
	$Members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach ($Members as $Member) {
		$MemberInterests = DB::queryFirstRow('SELECT sum(Amount) from interests where MembershipNumber=%s', $Member['MembershipNumber']);
		$Interests = $Interests + $MemberInterests['sum(Amount)'];
	}
	return $Interests;
}

function MembersumSavings($MembershipNumber)
{
	$MembersumSavings = DB::queryFirstRow('SELECT sum(Amount) as MembersumSavings from savings where MembershipNumber=%s', $MembershipNumber);
	return $MembersumSavings['MembersumSavings'];
}

//Calculate Available Guarantee Balance for a Member
// function AvailableGuaranteeBalance($MembershipNumber, $RequestingMembershipNumber = null){
// 	// Get member's total savings
// 	$savings = DB::queryFirstRow('SELECT sum(Amount) as TotalSavings from savings where MembershipNumber=%s', $MembershipNumber);
// 	$memberSavings = $savings['TotalSavings'] ?? 0;

// 	// Get already guaranteed amounts (only accepted guarantees for outstanding/pending loans)
// 	$gurantAmount = DB::queryFirstRow('SELECT sum(Amount) as guranteedAmount, sum(AmountPaid) as LoanPaid from guarantors where MembershipNumber=%s AND Status=%s AND LoanStatus IN %ls', $MembershipNumber, 'Accepted', ['OUTSTANDING', 'PENDING APPROVAL']);
// 	$totalGurantAmt = $gurantAmount['guranteedAmount'] ?? 0;
// 	$totalPaidLoan = $gurantAmount['LoanPaid'] ?? 0;

// 	// If member is guaranteeing themselves, apply 20% reserve
// 	if($MembershipNumber == $RequestingMembershipNumber){
// 		$gurantBalance = ($memberSavings - 0.2 * $memberSavings) - $totalGurantAmt + $totalPaidLoan;
// 	} else {
// 		$gurantBalance = $memberSavings - $totalGurantAmt + $totalPaidLoan;
// 	}

// 	return max(0, $gurantBalance); // Return 0 if negative
// }

//Expected Savings All Members
function ExpectedTotalSavings()
{
	$expectedAmount = 0;
	$CurrentDate = date('Y-m-d');
	$members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach ($members as $member) {
		$StartDate = '2022-01-01'; //From the date they joined
		$Years = date('Y', strtotime($CurrentDate)) - date('Y', strtotime($StartDate)); #Full Years
		$Months = date('m', strtotime($CurrentDate)) - date('m', strtotime($StartDate)); #Full Months
		$TotalMonths = ($Years * 12) + $Months;
		$TotalAmount = $TotalMonths * 200000;
		$expectedAmount += $TotalAmount;
	}
	return $expectedAmount;
}

//Expected Indivdual Savings
function ExpectedMemberSavings($MembershipNumber)
{
	$expectedAmount = 0;
	$CurrentDate = date('Y-m-d');
	$member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
	$StartDate = '2022-01-01'; //From the date they joined
	$Years = date('Y', strtotime($CurrentDate)) - date('Y', strtotime($StartDate)); #Full Years
	$Months = date('m', strtotime($CurrentDate)) - date('m', strtotime($StartDate)); #Full Months
	$TotalMonths = ($Years * 12) + $Months;
	$TotalAmount = $TotalMonths * 200000;
	$expectedAmount += $TotalAmount;
	return $expectedAmount;
}

//Outstanding Savings for all Members
function outstandingSavings()
{
	$sumOutstanding = 0;
	$members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach ($members as $member) {
		$expectedSaving = ExpectedMemberSavings($member['MembershipNumber']);
		$currentSaving = MembersumSavings($member['MembershipNumber']);
		$outstandingSaving = $expectedSaving - $currentSaving;

		if ($outstandingSaving < 0) {
			$sumOutstanding -= $outstandingSaving;
		}
		$sumOutstanding += $outstandingSaving;
	}
	return $sumOutstanding;
}

/** Welfare */
function sumWelfare()
{
	$sumWelfare = DB::queryFirstRow('SELECT sum(Amount) as sumWelfare from welfare');
	return $sumWelfare['sumWelfare'];
}
/** Loans */
function totalLoans()
{
	$loans = DB::queryFirstRow('SELECT sum(Principal) as totalLoans from loanrequests where (Status=%s OR Status=%s)', 'OUTSTANDING', 'CLEARED');
	return $loans['totalLoans'];
}

function totalLoanInterests()
{
	$loans = DB::queryFirstRow('SELECT sum(Amount) as totalLoanInterests from interests');
	return $loans['totalLoanInterests'];
}

function outstandingLoans()
{
	$loans = DB::queryFirstRow('SELECT sum(Balance) as outstandingLoans from loanrequests where Status=%s', 'OUTSTANDING');
	return $loans['outstandingLoans'];
}

function paidLoans()
{
	$paidLoans = DB::queryFirstRow('SELECT sum(AmountPaid) as paidLoans from loanpayments');
	return $paidLoans['paidLoans'];
}


/** Administrative Fees */
function sumFines()
{
	$sumFines = DB::queryFirstRow('SELECT sum(Amount) as sumFines from fines');
	return $sumFines['sumFines'];
}

function sumExpenses()
{
	$sumExpenses = DB::queryFirstRow('SELECT sum(Amount) as sumExpenses from expenses');
	return $sumExpenses['sumExpenses'];
}

function sumMemFees()
{ //Membership Fees
	$sumMemFees = DB::queryFirstRow('SELECT sum(Amount) as sumMemFees from membershipfees');
	return $sumMemFees['sumMemFees'];
}

function sumInvestments()
{ //Membership Fees
	$sumInvestments = DB::queryFirstRow('SELECT sum(Amount) as sumInvestments from investments');
	return $sumInvestments['sumInvestments'];
}
/**Investments */
function invDeposits()
{
	$invDeposits = DB::queryFirstRow('SELECT sum(amount) as sumDeposits from investment_transactions where trans_action=%s', 'Deposit');
	return $invDeposits['sumDeposits'];
}

function invInterests()
{
	$invInterests = DB::queryFirstRow('SELECT sum(amount) as sumInterests from investment_transactions where trans_action=%s', 'Interest');
	return $invInterests['sumInterests'];
}

function invWithdraws()
{
	$invWithdraws = DB::queryFirstRow('SELECT sum(amount) as sumWithdraws from investment_transactions where trans_action=%s', 'Withdraw');
	return $invWithdraws['sumWithdraws'];
}

function sumCashbank()
{
	//Welfare + Savings + Fines + Loan Payments + Membership + AnnualSubscription, fines- (Expenses, LoanRequests(Principal),
	$sumCashbank = (sumWelfare() + sumSavings() + paidLoans() + sumMemFees() + sumFines() + invWithdraws()) - sumExpenses() - totalLoans() - invDeposits();
	return $sumCashbank;
}
