<?php
session_start();
require_once('defines/functions.php');

$email = htmlspecialchars(( isset( $_REQUEST['email'] ) )?  $_REQUEST['email']: null);
$password = htmlspecialchars(( isset( $_REQUEST['password'] ) )?  $_REQUEST['password']: null);
$type = htmlspecialchars(( isset( $_REQUEST['type'] ) )?  $_REQUEST['type']: null);
$date = date('Y-m-d H:i:s');

if($type == "admin"){
	//Administrator Login//
	$sysUser = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s order by id desc limit 1', $email);
	if(isset($sysUser['EmailAddress'])){
		if(password_verify($password, $sysUser['Password'])){
			DB::update("systemusers",array("LastLogin"=>$date),"AccId=%s",$sysUser['AccId']);
			$_SESSION['signed_in'] = true;
			$_SESSION['AccId'] = $sysUser['AccId'];
			header("Location:scripts/dashboard.php");
		}
		else{
			$_SESSION['signed_in'] = false;
			$_SESSION['AccId'] = null;
			$_SESSION['Error'] = 'Incorrect password';
			header("Location:index.php");
		}
	}
	else{
		$_SESSION['Error'] = "Account not found!";
		header("Location:index.php");
	}
}
else{
	//Member Login//
	$memUser = DB::queryFirstRow('SELECT * from members where EmailAddress=%s AND AccStatus=%s order by id desc limit 1', $email, 'Active');
	if(isset($memUser['EmailAddress'])){
		if(password_verify($password, $memUser['Password'])){
			DB::update("members",array("LastLogin"=>$date),"MembershipNumber=%s",$memUser['MembershipNumber']);
			$_SESSION['signed_in'] = true;
			$_SESSION['MembershipNumber'] = $memUser['MembershipNumber'];
			$_SESSION['Fullname'] = $memUser['Fullname'];
			header("Location:members/dashboard.php");
		}
		else{
			$_SESSION['signed_in'] = false;
			$_SESSION['MembershipNumber'] = null;
			$_SESSION['Fullname'] = null;
			$_SESSION['Error'] = 'Incorrect password';
			header("Location:index.php");
		}
	}
	else{
		$_SESSION['Error'] = "Account not found or De-Activated. Please contact the System's Administrator for further assistance.";
		header("Location:index.php");
	}
}
?>