<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$refundType = htmlspecialchars(( isset( $_REQUEST['refundType'] ) )?  $_REQUEST['refundType']: null);
$RefundsID = htmlspecialchars(( isset( $_REQUEST['RefundsID'] ) )?  $_REQUEST['RefundsID']: null);

$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

if($refundType == "ADD"){
        $NewRefund = array(
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('refunds', $NewRefund);
        $_SESSION['Success'] = "Refund of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
        header('Location: refunds.php');
    }
elseif($refundType == "EDIT"){
    $UpdateDate = date('Y-m-d H:i:s');

    $EditRefund = array(
    'Amount'=>$Amount,
    'Narration'=>$Narration,
    'TransactionDate'=>$transaction_date,
    'DateUpdated'=>$UpdateDate,
    );
    
    DB::update('refunds', $EditRefund, 'Id=%s', $RefundsID);
    $_SESSION['Success'] = "Refund of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    header('Location: refunds.php');
}
?>