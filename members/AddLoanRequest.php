<?php
require_once('../defines/functions.php');
require_once('../validate.php');

$LoanId = genSavId();
$MembershipNumber = $_SESSION['MembershipNumber'];


$LoanType = htmlspecialchars((isset($_REQUEST['LoanType'])) ?  $_REQUEST['LoanType'] : null);
$Principal = htmlspecialchars((isset($_REQUEST['Amount'])) ?  $_REQUEST['Amount'] : null);
$Rate = htmlspecialchars((isset($_REQUEST['Rate'])) ?  $_REQUEST['Rate'] : null);
$Interest = htmlspecialchars((isset($_REQUEST['Interest'])) ?  $_REQUEST['Interest'] : null);
$TotalAmount = htmlspecialchars((isset($_REQUEST['TotalAmount'])) ?  $_REQUEST['TotalAmount'] : null);
$LoanPeriod = htmlspecialchars((isset($_REQUEST['LoanPeriod'])) ?  $_REQUEST['LoanPeriod'] : null);
$GuarantorMembershipNumber = (isset($_REQUEST['GuarantorMembershipNumber'])) ?  $_REQUEST['GuarantorMembershipNumber'] : null;
$GuarantorAmount = (isset($_REQUEST['GuarantorAmount'])) ?  $_REQUEST['GuarantorAmount'] : null;
$Status = "PENDING APPROVAL";
$Principal = str_replace(',', '', $Principal);
$Interest = str_replace(',', '', $Interest);
$TotalAmount = str_replace(',', '', $TotalAmount);
$GuarantorAmount = str_replace(',', '', $GuarantorAmount);

$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);

$max_loan = (MembersumSavings($MembershipNumber) - (0.2 * MembersumSavings($MembershipNumber))) * 3;
if ($Principal > $max_loan) {
	$_SESSION['Error'] = "You cannot make a loan request of more than <b>UGX " . number_format($max_loan) . ".</b>";
	header('Location: requestLoan.php');
	exit();
}

//Add the Main Loan Now
//Does Member have an Outstanding Main Loan
$LoanRequest = DB::queryFirstRow('SELECT * from loanrequests where MembershipNumber=%s AND (Status=%s or Status=%s) AND LoanType=%s', $MembershipNumber, 'OUTSTANDING', 'PENDING APPROVAL', 'Main');
if ($LoanRequest['Status'] == "OUTSTANDING") {
	$_SESSION['Error'] = "You still have an outstanding Main loan of UGX" . number_format($LoanRequest['Balance']);
	header('Location: requestLoan.php');
	exit();
} elseif ($LoanRequest['Status'] == "PENDING APPROVAL") {
	$_SESSION['Error'] = "You have a loan pending approval.";
	header('Location: requestLoan.php');
	exit();
} else {
	//Add the Main Loan
	$NewLoan = array(
		'LoanId' => $LoanId,
		'LoanType' => $LoanType,
		'MembershipNumber' => $MembershipNumber,
		'Principal' => $Principal,
		'Rate' => $Rate,
		'Interest' => $Interest,
		'TotalAmount' => $TotalAmount,
		'LoanPeriod' => $LoanPeriod,
		'Status' => $Status,
		'Balance' => $TotalAmount,
		'CreatedBy' => $Member['Fullname'] . "{SACCO Member}",
	);
	DB::insert('loanrequests', $NewLoan);

	// Approval flow: Treasurer(3) >> Chairperson(1)
	$loanapprovals = array(
		'LoanId' => $LoanId,
		'RoleId' => 3,
		'ReviewBy' => "",
		'ReviewId' => "",
		'Status' => 'Pending Review by Treasurer.',
		'Narration' => "",
	);
	DB::insert('loanapprovals', $loanapprovals);

	//Record this history
	$LoanHistory = array(
		'LoanId' => $LoanId,
		'TransactionType' => 'Loan Request',
		'Amount' => $TotalAmount,
		'AddedBy' => $Member['Fullname'] . "{SACCO Member}",
	);
	DB::insert('loanhistory', $LoanHistory);

	//Add the Guarantor - Validate each guarantor's available balance first
	
	foreach ($GuarantorMembershipNumber as $a => $b) {
		$gurant_status = "Pending";
		if ($GuarantorMembershipNumber[$a] == $MembershipNumber) {
			$gurant_status = "Accepted";
		}
		$GuarantorDetails = array(
			'LoanId' => $LoanId,
			'MembershipNumber' => $GuarantorMembershipNumber[$a],
			'Amount'=> $GuarantorAmount[$a],
			'Status' => $gurant_status,
			'Comments' => "",
			'LoanStatus' => $Status,
		);
		DB::insert('guarantors', $GuarantorDetails);
		$TableId = "GR - " . DB::insertId();

		//Send the SMS to the Guarantors
		$GuarantorMember = DB::queryFirstRow("SELECT * from members where MembershipNumber=%s", $GuarantorMembershipNumber[$a]);
		$SMS = "Dear " . $GuarantorMember['Fullname'] . ", " . $Member['Fullname'] . " is requesting you to be a Loan Guarantor. Please login to your Trek Investment account to accept or decline the request.";
		// SendSms(formatNumber($GuarantorMember['MSISDN']), $SMS, $TableId, "SYSTEM");
	}
	//End Task			
	$_SESSION['Success'] = "Your loan request has been received and is pending approval.";
	header('Location: requestLoan.php');
}
