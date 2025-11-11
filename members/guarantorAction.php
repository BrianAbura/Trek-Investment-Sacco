<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$GuarantorId = htmlspecialchars(( isset( $_REQUEST['GuarantorId'] ) )?  $_REQUEST['GuarantorId']: null);
$Status = htmlspecialchars(( isset( $_REQUEST['Status'] ) )?  $_REQUEST['Status']: null);
$Comments = htmlspecialchars(( isset( $_REQUEST['Comments'] ) )?  $_REQUEST['Comments']: null);

// If accepting, validate that guarantor has sufficient available balance
// if ($Status == "Accepted") {
//     // Get guarantor details
//     $guarantor = DB::queryFirstRow('SELECT * from guarantors where Id=%s', $GuarantorId);
    
//     if ($guarantor) {
//         // Get loan details to find the requesting member
//         $loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $guarantor['LoanId']);
        
//         // Check available balance
//         $availableBalance = AvailableGuaranteeBalance($guarantor['MembershipNumber'], $loan['MembershipNumber']);
//         $requestedAmount = $guarantor['Amount'];
        
//         if ($requestedAmount > $availableBalance) {
//             echo "Error: You cannot guarantee UGX " . number_format($requestedAmount) . ". Your available guarantee balance is only UGX " . number_format($availableBalance) . ". Please contact the loan requester to adjust the amount.";
//             exit();
//         }
//     }
// }

    $GurantAction = array(
    'Status'=>$Status,
    'Comments'=>$Comments,
    );

    DB::update('guarantors', $GurantAction, 'Id=%s', $GuarantorId);
    echo "Your response has been successfully captured."
?>
