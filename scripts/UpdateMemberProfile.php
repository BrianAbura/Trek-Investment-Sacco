<?php 
//Adding New member

require_once('../defines.php');
require_once('../validate.php');
require_once('functions.php');

$sysUser = DB::queryFirstRow('SELECT * from systemusers where AccId=%s',$_SESSION['AccId']);
$CreatedBy = $sysUser['Name']."{".$sysUser['Role']."}";

$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$Name = htmlspecialchars(( isset( $_REQUEST['Name'] ) )?  $_REQUEST['Name']: null);
$DOB = htmlspecialchars(( isset( $_REQUEST['DOB'] ) )?  $_REQUEST['DOB']: null);
$MSISDN = htmlspecialchars(( isset( $_REQUEST['MSISDN'] ) )?  $_REQUEST['MSISDN']: null);
$EmailAddress = htmlspecialchars(( isset( $_REQUEST['EmailAddress'] ) )?  $_REQUEST['EmailAddress']: null);
$Occupation = htmlspecialchars(( isset( $_REQUEST['Occupation'] ) )?  $_REQUEST['Occupation']: null);
$PositionInGroup = htmlspecialchars(( isset( $_REQUEST['PositionInGroup'] ) )?  $_REQUEST['PositionInGroup']: null);
$CurrentUploadPicture = htmlspecialchars(( isset( $_REQUEST['CurrentUploadPicture'] ) )?  $_REQUEST['CurrentUploadPicture']: null);
$target_dir = "../profiles/";
$target_file = $target_dir . basename($_FILES["ProfilePicture"]["name"]);

$DOB = date_format(date_create($DOB),"Y-m-d");

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s',$AccNumber);

if(!empty(basename($_FILES["ProfilePicture"]["name"]))){

	//Check the images properties
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$_SESSION['error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
			header("Location: editMember.php?AccNumber=$AccNumber");
			exit();
		}
		else{
			move_uploaded_file($_FILES["ProfilePicture"]["tmp_name"], $target_file);
		}
}
else{
	
	$target_file = $CurrentUploadPicture;
}

//Add the Member

		$UpdateMember = array(
		'Name'=>$Name,
		'DOB'=>$DOB,
		'MSISDN'=>$MSISDN,
		'EmailAddress'=>$EmailAddress,
		'Occupation'=>$Occupation,
		'PositionInGroup'=>$PositionInGroup,
		'ProfilePicture'=>$target_file,
		'DateUpdated'=>date('Y-m-d H:i:s'),
		);

		DB::update('members', $UpdateMember, 'AccNumber=%s',$AccNumber);
		$_SESSION['msg'] = $Name." has been Updated SUCCESSFULLY.";
		header("Location: editMember.php?AccNumber=$AccNumber");
?>