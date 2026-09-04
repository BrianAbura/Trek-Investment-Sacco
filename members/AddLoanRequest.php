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
$GuarantorMembershipNumber = $_REQUEST['GuarantorMembershipNumber'];
$GuarantorAmount = $_REQUEST['GuarantorAmount'];
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

//Check whether the member already has an outstanding or pending loan
$LoanRequest = DB::queryFirstRow('SELECT * from loanrequests where MembershipNumber=%s AND (Status=%s or Status=%s)', $MembershipNumber, 'OUTSTANDING', 'PENDING APPROVAL');
if ($LoanRequest && $LoanRequest['Status'] == "OUTSTANDING") {
	$_SESSION['Error'] = "You still have an outstanding loan of UGX " . number_format($LoanRequest['Balance']) . ".";
	header('Location: requestLoan.php');
	exit();
} elseif ($LoanRequest && $LoanRequest['Status'] == "PENDING APPROVAL") {
	$_SESSION['Error'] = "You have a loan pending approval.";
	header('Location: requestLoan.php');
	exit();
} else {
	$availableSavings = AvailableSavings($MembershipNumber);
	$amountAboveBorrower = $Principal - $availableSavings;

	//Validate additional guarantor coverage when the loan exceeds the borrower's available savings
	if ($amountAboveBorrower > 0) {
		$additionalCovered = 0;
		$seenGuarantors = array();
		if (empty($GuarantorMembershipNumber) || !is_array($GuarantorMembershipNumber)) {
			$_SESSION['Error'] = "Additional guarantors are required to cover UGX " . number_format($amountAboveBorrower) . " above your available savings.";
			header('Location: requestLoan.php');
			exit();
		}
		foreach ($GuarantorMembershipNumber as $a => $b) {
			if (empty($GuarantorMembershipNumber[$a]) || empty($GuarantorAmount[$a])) {
				continue;
			}
			//Skip if the borrower themselves are submitted; they are handled automatically
			if ($GuarantorMembershipNumber[$a] == $MembershipNumber) {
				continue;
			}
			//Prevent the same guarantor from being selected more than once
			if (in_array($GuarantorMembershipNumber[$a], $seenGuarantors)) {
				$_SESSION['Error'] = "Guarantor " . $GuarantorMembershipNumber[$a] . " has been added more than once. Please use a single row for each guarantor.";
				header('Location: requestLoan.php');
				exit();
			}
			$seenGuarantors[] = $GuarantorMembershipNumber[$a];
			$GuarantorMember = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s AND AccStatus=%s', $GuarantorMembershipNumber[$a], 'Active');
			if (!$GuarantorMember) {
				$_SESSION['Error'] = "Invalid guarantor selected.";
				header('Location: requestLoan.php');
				exit();
			}
			$existingLoan = DB::queryFirstRow('SELECT * from loanrequests where MembershipNumber=%s AND Status IN %ls', $GuarantorMembershipNumber[$a], ['OUTSTANDING', 'PENDING APPROVAL', 'APPROVED']);
			if ($existingLoan) {
				$_SESSION['Error'] = "Guarantor " . $GuarantorMember['Fullname'] . " is not eligible because they have an existing loan.";
				header('Location: requestLoan.php');
				exit();
			}
			$guarantorAvailable = AvailableSavings($GuarantorMembershipNumber[$a]);
			if ($GuarantorAmount[$a] > $guarantorAvailable) {
				$_SESSION['Error'] = "Guarantor " . $GuarantorMember['Fullname'] . " cannot guarantee more than UGX " . number_format($guarantorAvailable) . ".";
				header('Location: requestLoan.php');
				exit();
			}
			$additionalCovered += $GuarantorAmount[$a];
		}
		if ($additionalCovered < $amountAboveBorrower) {
			$_SESSION['Error'] = "Additional guarantors must cover UGX " . number_format($amountAboveBorrower) . ". Currently covered: UGX " . number_format($additionalCovered) . ".";
			header('Location: requestLoan.php');
			exit();
		}
	}

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

	//Add the borrower as the first guarantor when the loan requires additional backing
	if ($amountAboveBorrower > 0 && $availableSavings > 0) {
		$BorrowerGuarantee = array(
			'LoanId' => $LoanId,
			'MembershipNumber' => $MembershipNumber,
			'Amount' => $availableSavings,
			'Status' => 'Accepted',
			'Comments' => "",
			'LoanStatus' => $Status,
		);
		DB::insert('guarantors', $BorrowerGuarantee);
	}

	//Add the additional guarantors
	if ($amountAboveBorrower > 0 && !empty($GuarantorMembershipNumber) && is_array($GuarantorMembershipNumber)) {
		foreach ($GuarantorMembershipNumber as $a => $b) {
			if (empty($GuarantorMembershipNumber[$a]) || empty($GuarantorAmount[$a])) {
				continue;
			}
			//The borrower is handled separately above
			if ($GuarantorMembershipNumber[$a] == $MembershipNumber) {
				continue;
			}
			$GuarantorDetails = array(
				'LoanId' => $LoanId,
				'MembershipNumber' => $GuarantorMembershipNumber[$a],
				'Amount' => $GuarantorAmount[$a],
				'Status' => 'Pending',
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
	}
	//End Task			
	$_SESSION['Success'] = "Your loan request has been received and is pending approval.";
	header('Location: requestLoan.php');
}
