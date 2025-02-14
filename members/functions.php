<?php 
function GuaranteeRequests($MembershipNumber){
	DB::query("SELECT * FROM guarantors WHERE MembershipNumber=%s AND Status=%s", $MembershipNumber, "Pending");
	$requests = DB::count();
	return $requests;
}

function TotalSavings($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as TotalSavings from savings where MembershipNumber=%s', $MembershipNumber);
	return $query['TotalSavings'];
}

function TotalWelfare($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as TotalWelfare from welfare where MembershipNumber=%s', $MembershipNumber);
	return $query['TotalWelfare'];
}

function TotalShareValue($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(SharesPurchased * ShareValue) as TotalShareValue from shares where MembershipNumber=%s', $MembershipNumber);
	return $query['TotalShareValue'];
}

function TotalFines($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as TotalFines from fines where MembershipNumber=%s', $MembershipNumber);
	return $query['TotalFines'];
}

function LoansRequests($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(Principal) as TotalLoanBorrowed from loanrequests where MembershipNumber=%s AND (Status=%s or Status=%s)', $MembershipNumber, 'OUTSTANDING', 'CLEARED');
	return $query['TotalLoanBorrowed'];
}

function LoanPayments($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(AmountPaid) as TotalLoanPayments from loanpayments where MembershipNumber=%s', $MembershipNumber);
	return $query['TotalLoanPayments'];
}

function LoanGuaranteed($MembershipNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as LoanGuaranteed from guarantors where MembershipNumber=%s AND Status=%s AND (LoanStatus=%s or LoanStatus=%s)', $MembershipNumber, "Accepted", "OUTSTANDING", "CLEARED");
	return $query['LoanGuaranteed'];
}

function MemOutstandingLoans($MembershipNumber){
	$balance = 0;
	$query = DB::queryFirstRow('SELECT Balance from loanrequests where MembershipNumber=%s AND Status=%s', $MembershipNumber, "OUTSTANDING");
	if($query){
		$balance =  $query['Balance'];
	}
	return $balance;
}
function MemOutstandingSavings($MembershipNumber){
	
	return 0;
}
?>
