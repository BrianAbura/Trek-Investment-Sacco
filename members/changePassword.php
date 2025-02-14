<?php 
//Change Password
require_once('../defines/functions.php');
require_once('../validate.php');

$oldPass = htmlspecialchars(( isset( $_REQUEST['oldPass'] ) )?  $_REQUEST['oldPass']: null);
$newPass = htmlspecialchars(( isset( $_REQUEST['newPass'] ) )?  $_REQUEST['newPass']: null);
$newPass2 = htmlspecialchars(( isset( $_REQUEST['newPass2'] ) )?  $_REQUEST['newPass2']: null);
	
	$member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s order by id desc limit 1',$_SESSION['MembershipNumber']);
	if($newPass != $newPass2){
		$_SESSION['Error'] = "The new passwords do not match.";
	}
	else{
		if(password_verify($oldPass, $member['Password'])){
		$hashed_pass = password_hash($newPass, PASSWORD_DEFAULT);
		DB::update("members",array("Password"=>$hashed_pass, 'DateUpdated'=>date('Y-m-d H:i:s')),"MembershipNumber=%s",$_SESSION['MembershipNumber']);
		$_SESSION['Success'] = "You Password was Successfully Changed.";
		}
		else{
			$_SESSION['Error'] = "Your old password is incorrect.";
		}
	}
header('Location: memberProfile.php');

?>