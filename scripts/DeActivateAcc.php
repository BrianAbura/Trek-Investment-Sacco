<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$MembershipNumber = ( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null;
$Action = ( isset( $_REQUEST['Action'] ) )?  $_REQUEST['Action']: null;

$UpdateDate = date('Y-m-d H:i:s');
//Deactivating Member's Account.

$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);

if($Action == "DeActivate"){
	$LoanRequest = DB::queryFirstRow('SELECT * from loanrequests where MembershipNumber=%s AND Status=%s',$MembershipNumber,'OUTSTANDING');
	if($LoanRequest){
		echo $Member['Fullname']."'s account cannot be de-activated due to an outstanding loan.";
	}
	else{
		//Deactivate account//More Action to be performed
		DB::update('members', array('AccStatus'=>'Inactive', 'DateUpdated'=> $UpdateDate), 'MembershipNumber=%s', $Member['MembershipNumber']);
		echo $Member['Fullname']."'s account has been De-Activated.";
	}
}
elseif($Action == "Activate"){
	DB::update('members', array('AccStatus'=>'Active', 'DateUpdated'=> $UpdateDate), 'MembershipNumber=%s', $Member['MembershipNumber']);
	echo $Member['Fullname']."'s account has been Activated.";
}
elseif($Action == "Reset"){
	$hashed_pass = password_hash($Member['EmailAddress'], PASSWORD_DEFAULT);
	DB::update("members",array("Password"=>$hashed_pass, 'DateUpdated'=>$UpdateDate),"MembershipNumber=%s",$MembershipNumber);
	echo $Member['Fullname']."'s password has been reset. New Password is the current Email Address.";
}
else{
	echo "No Action";
}
?>