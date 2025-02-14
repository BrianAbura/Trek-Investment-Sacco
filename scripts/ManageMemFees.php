<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$memFeeType = htmlspecialchars(( isset( $_REQUEST['memFeeType'] ) )?  $_REQUEST['memFeeType']: null);
$MemFeeID = htmlspecialchars(( isset( $_REQUEST['MemFeeID'] ) )?  $_REQUEST['MemFeeID']: null);

$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$subscription_year = htmlspecialchars(( isset( $_REQUEST['subscription_year'] ) )?  $_REQUEST['subscription_year']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

if($Narration == "Annual"){
    $Narration = "Annual Subscription for ".$subscription_year;
}

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

if($memFeeType == "ADD"){
        $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
        $NewMemFee = array(
        'MembershipNumber'=>$MembershipNumber,
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'Amount'=>$Amount,
        'DateAdded'=>$transaction_date,
        'CreatedBy'=>$CreatedBy,
        );
        
        DB::insert('membershipfees', $NewMemFee);
        $_SESSION['Success'] = $member['Fullname']."'s ".$Narration." of UGX".number_format($Amount)." has been captured Successfully.";
        header('Location: membershipFees.php');
    }
elseif($memFeeType == "EDIT"){
    $UpdateDate = date('Y-m-d H:i:s');

    $membershipFee = DB::queryFirstRow('SELECT * from membershipfees where Id=%s', $MemFeeID);
    $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $membershipFee['MembershipNumber']);
    $EditMemFee = array(
    'Amount'=>$Amount,
    'Narration'=>$Narration,
    'DateAdded'=>$transaction_date,
    'DateUpdated'=>$UpdateDate,
    );
    
    DB::update('membershipfees', $EditMemFee, 'Id=%s', $MemFeeID);
    $_SESSION['Success'] = $member['Fullname']."'s ".$Narration." of UGX".number_format($Amount)." has been updated Successfully.";
    header('Location: membershipFees.php');
}
?>