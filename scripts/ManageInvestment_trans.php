<?php 
#Manage the Savings from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$transaction_id = htmlspecialchars(( isset( $_REQUEST['transaction_id'] ) )?  $_REQUEST['transaction_id']: null);
//Incase of Edits
$transaction_action = htmlspecialchars(( isset( $_REQUEST['transaction_action'] ) )?  $_REQUEST['transaction_action']: null);
$investment_id = htmlspecialchars(( isset( $_REQUEST['investment_id'] ) )?  $_REQUEST['investment_id']: null);
$trans_action = htmlspecialchars(( isset( $_REQUEST['trans_action'] ) )?  $_REQUEST['trans_action']: null);
$amount = htmlspecialchars(( isset( $_REQUEST['amount'] ) )?  $_REQUEST['amount']: null);
$date = htmlspecialchars(( isset( $_REQUEST['date'] ) )?  $_REQUEST['date']: null);
$description = htmlspecialchars(( isset( $_REQUEST['description'] ) )?  $_REQUEST['description']: null);

#Some Edits
$date = date_format(date_create($date),"Y-m-d");
$amount = str_replace(',','', $amount);

if($transaction_action == "Add_New_Transction"){
	//Add the Investment
		$query = array(
		'investment_id'=>$investment_id,
		'trans_action'=>$trans_action,
		'amount'=>$amount,
		'description'=>$description,
		'trans_date'=>$date,
		'AddedBy'=>$CreatedBy,
		);
		DB::insert('investment_transactions', $query);
		
		$_SESSION['Success'] = "Investment Transaction has been added Successfully.";
		header("Location:investment_details.php?investment_id=".$investment_id);
	}
elseif($transaction_action == "Del_Transction"){
	DB::delete('investment_transactions', "id=%s", $transaction_id);
	echo "Investment transaction deleted.";
}
?>