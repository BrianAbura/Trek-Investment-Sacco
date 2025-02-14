<?php 
//Change Password
require_once('../defines/functions.php');
require_once('../validate.php');

$sysUser = DB::queryFirstRow('SELECT * from systemusers where AccId=%s',$_SESSION['AccId']);

$oldPass = htmlspecialchars(( isset( $_REQUEST['oldPass'] ) )?  $_REQUEST['oldPass']: null);
$newPass = htmlspecialchars(( isset( $_REQUEST['newPass'] ) )?  $_REQUEST['newPass']: null);
$newPass2 = htmlspecialchars(( isset( $_REQUEST['newPass2'] ) )?  $_REQUEST['newPass2']: null);
	
	if($newPass != $newPass2){
		$_SESSION['Error'] = "New passwords do not match.";
	}
	else{
		if(password_verify($oldPass, $sysUser['Password'])){
		$hashed_pass = password_hash($newPass, PASSWORD_DEFAULT);
		DB::update("systemusers",array("Password"=>$hashed_pass, 'DateUpdated'=>date('Y-m-d H:i:s')),"AccId=%s",$_SESSION['AccId']);
		$_SESSION['Success'] = "Password Successfully Changed.";
		}
		else{
			$_SESSION['Error'] = "Your old password is incorrect";
		}
	}
header('Location: sysMemberProfile.php');

?>