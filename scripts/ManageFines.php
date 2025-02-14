<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$adminfeeType = htmlspecialchars(( isset( $_REQUEST['adminfeeType'] ) )?  $_REQUEST['adminfeeType']: null);
$adminFeeAction = htmlspecialchars(( isset( $_REQUEST['adminFeeAction'] ) )?  $_REQUEST['adminFeeAction']: null);
$editFineID = htmlspecialchars(( isset( $_REQUEST['editFineID'] ) )?  $_REQUEST['editFineID']: null);

$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

if($adminFeeAction == "ADD"){
        $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
        $NewFine = array(
        'MembershipNumber'=>$MembershipNumber,
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('fines', $NewFine);
        $TableId = "FN - ".DB::insertId();
        $SMS = "Your Fines to TREK of UGX ".number_format($Amount)." for ".$Narration." has been received. Thank you.";
	    SendSms(formatNumber($member['MSISDN']), $SMS, $TableId, "SYSTEM");

        $_SESSION['Success'] = $member['Fullname']."'s fine of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
        header('Location: fines.php');
    }
elseif($adminFeeAction == "EDIT"){
    $UpdateDate = date('Y-m-d H:i:s');

    $fine = DB::queryFirstRow('SELECT * from fines where Id=%s', $editFineID);
    $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $fine['MembershipNumber']);
    $EditFine = array(
    'Amount'=>$Amount,
    'Narration'=>$Narration,
    'TransactionDate'=>$transaction_date,
    'DateUpdated'=>$UpdateDate,
    );
    
    DB::update('fines', $EditFine, 'Id=%s', $editFineID);
    $_SESSION['Success'] = $member['Fullname']."'s fine of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    header('Location: fines.php');
}
?>