<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$investmentAction = htmlspecialchars(( isset( $_REQUEST['investmentAction'] ) )?  $_REQUEST['investmentAction']: null);
$investmentID = htmlspecialchars(( isset( $_REQUEST['investmentID'] ) )?  $_REQUEST['investmentID']: null);

$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

    if($investmentAction == "ADD"){
        
        $Newinvestment = array(
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('investments', $Newinvestment);
        $_SESSION['Success'] = "Investment transaction of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
    }
    elseif($investmentAction == "EDIT"){
        $UpdateDate = date('Y-m-d H:i:s');
        
        $investmentEdit = array(
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'DateUpdated'=>$UpdateDate,
        );
        
        DB::update('investments', $investmentEdit, 'Id=%s', $investmentID);
        $_SESSION['Success'] = "Investment transaction of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    }

    header('Location: investments.php');
?>