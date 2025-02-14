<?php 
#Manage the Savings from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$investment_action = htmlspecialchars(( isset( $_REQUEST['investment_action'] ) )?  $_REQUEST['investment_action']: null);
$investment_id = htmlspecialchars(( isset( $_REQUEST['investment_id'] ) )?  $_REQUEST['investment_id']: null);

$investment_name = htmlspecialchars(( isset( $_REQUEST['investment_name'] ) )?  $_REQUEST['investment_name']: null);
$investment_type = htmlspecialchars(( isset( $_REQUEST['investment_type'] ) )?  $_REQUEST['investment_type']: null);
$investment_date = htmlspecialchars(( isset( $_REQUEST['investment_date'] ) )?  $_REQUEST['investment_date']: null);

#Some Edits
$investment_date = date_format(date_create($investment_date),"Y-m-d");

if($investment_action == "Add_New_Investment"){
	//Add the Investment
		$query = array(
		'investment_name'=>$investment_name,
		'investment_date'=>$investment_date,
		'investment_type'=>$investment_type,
		'AddedBy'=>$CreatedBy,
		);
		DB::insert('investments', $query);
		
		$_SESSION['Success'] = $investment_name." investment has been added Successfully.";
		header('Location: investments.php');
	}
elseif($investment_action == "Edit_Investment"){
		$investment = DB::queryFirstRow('SELECT * from investments where id=%s', $investment_id);
		if(!$investment){
			$_SESSION['Error'] = "The selected investment option does not exist.";
			header("Location:Investments.php");
		}
		else{
			$query = array(
			'investment_name'=>$investment_name,
			'investment_date'=>$investment_date,
			'investment_type'=>$investment_type,
			);
			DB::update('investments', $query, 'id=%s', $investment_id);
			
			$_SESSION['Success'] = $investment_name." investment has been updated Successfully.";
			header("Location:investment_details.php?investment_id=".$investment_id);
		}
	}
elseif($investment_action == "Del_Investment"){
	$query = DB::queryFirstRow('SELECT * from investment_transactions where investment_id=%s', $investment_id);
	if($query){
		$response = array("Error" => "This investment cannot be deleted because it has active transactions. <br/> Remove active transactions then try again.");
		echo json_encode($response);
		exit();
	}
	else{
		DB::delete('investments', "id=%s", $investment_id);
		$response = array("Success" => "This investment has been deleted.");
		echo json_encode($response);
		exit();
	}
}
?>