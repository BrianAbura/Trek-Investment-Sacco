<?php
//Forgot Password
session_start();
require_once('defines/functions.php');

$emailPhone = htmlspecialchars(( isset( $_REQUEST['emailPhone'] ) )?  $_REQUEST['emailPhone']: null);
$type = htmlspecialchars(( isset( $_REQUEST['type'] ) )?  $_REQUEST['type']: null);
$dateUpdated = date('Y-m-d H:i:s');

if($type == "Admin"){
	//Administrator Check//
	$sysUser = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s OR MSISDN=%s', $emailPhone, $emailPhone);
	if($sysUser){
        $tempPass = genPassword();
        DB::update("systemusers",array("Password"=>password_hash($tempPass, PASSWORD_DEFAULT),"DateUpdated"=>$dateUpdated),"AccId=%s",$sysUser['AccId']);
        $SMS = "Dear ".$sysUser['Name']." your password has been reset. Login using your email and this temporary password: ".$tempPass.". <br/> Change your password once logged in.".
        #SendSms(formatNumber($sysUser['MSISDN']), $SMS, 'SYSA - '.$sysUser['Id'], "SYSTEM");
        $_SESSION['Success'] = $tempPass; #"Your password has been Reset Successfully. Check your phone or Email for the new login details.";
        header("Location: index.php");
    }
	else{
        $_SESSION['Error'] = "Account not found or De-Activated. Please contact your Administrator for further assistance.";
        header("Location:index.php");
		}
}
elseif($type="Member"){
	//Member Login//
	$Member = DB::queryFirstRow('SELECT * from members where EmailAddress=%s OR MSISDN=%s AND AccStatus=%s', $emailPhone, $emailPhone, 'Active');
	if($Member){
        $tempPass = genPassword();
        DB::update("members",array("Password"=>password_hash($tempPass, PASSWORD_DEFAULT),"DateUpdated"=>$dateUpdated),"MembershipNumber=%s",$Member['MembershipNumber']);
        $SMS = "Dear ".$Member['Fullname']." your password has been reset. Login using your email and this temporary password: ".$tempPass.". <br/> Change your password once logged in.".
        #SendSms(formatNumber($Member['MSISDN']), $SMS, 'MEM - '.$Member['Id'], "SYSTEM");
        $_SESSION['Success'] = $tempPass; #"Your password has been Reset Successfully. Check your phone or Email for the new login details.";
        header("Location: index.php");
    }
	else{
        $_SESSION['Error'] = "Account not found or De-Activated. Please contact your Administrator for further assistance.";
        header("Location:index.php");
		}
}
else{
    $_SESSION['Error'] = "An error occured while processing your request. Please try again later.";
    header("Location:index.php");
}
?>