<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$bankInterestType = htmlspecialchars(( isset( $_REQUEST['bankInterestType'] ) )?  $_REQUEST['bankInterestType']: null);
$BankInterestsID = htmlspecialchars(( isset( $_REQUEST['BankInterestsID'] ) )?  $_REQUEST['BankInterestsID']: null);

$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

if($bankInterestType == "ADD"){
        $NewBankInterest = array(
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('bankinterests', $NewBankInterest);
        $_SESSION['Success'] = "Bank Interest of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
        header('Location:bankinterests.php');
    }
elseif($bankInterestType == "EDIT"){
    $UpdateDate = date('Y-m-d H:i:s');

    $EditBankInterest = array(
    'Amount'=>$Amount,
    'Narration'=>$Narration,
    'TransactionDate'=>$transaction_date,
    'DateUpdated'=>$UpdateDate,
    );
    
    DB::update('bankinterests', $EditBankInterest, 'Id=%s', $BankInterestsID);
    $_SESSION['Success'] = "Bank Interest of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    header('Location:bankinterests.php');
}
?>