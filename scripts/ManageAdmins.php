<?php 
//Adding New member
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//For Edits
$AdminAction = htmlspecialchars(( isset( $_REQUEST['AdminAction'] ) )?  $_REQUEST['AdminAction']: null);
$EditMemID = htmlspecialchars(( isset( $_REQUEST['EditMemID'] ) )?  $_REQUEST['EditMemID']: null);
$AccStatus = htmlspecialchars(( isset( $_REQUEST['AccStatus'] ) )?  $_REQUEST['AccStatus']: null);

//For DeleteDelRowId
$DelRowId = htmlspecialchars(( isset( $_REQUEST['DelRowId'] ) )?  $_REQUEST['DelRowId']: null);

$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Role = htmlspecialchars(( isset( $_REQUEST['Role'] ) )?  $_REQUEST['Role']: null);
$target_dir = "../fileUploads/signatures/";


if($AdminAction == "Add_Admin"){
	$queryRole = DB::queryFirstRow('SELECT Designation from roles where RoleId=%s', $Role);
	$Designation = $queryRole['Designation'];
	$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
    $checkAdminRole = DB::queryFirstRow('SELECT * from systemusers where MembershipNumber=%s', $MembershipNumber);
		//Check Email Availability
		if($checkAdminRole){
			$_SESSION['Error'] = $Member['Fullname']." has already been assigned an Administrative role.";
			header('Location: administrativeMembers.php');
			exit();
		}
		else{

			$signature_file = basename($_FILES["SignatureUpload"]["name"]);
			$imageFileType = strtolower(pathinfo($signature_file,PATHINFO_EXTENSION));
			$imageName = 'Signature-'.$MembershipNumber.'-'.str_replace(" ", "_", $Member['Fullname']).'.' . $imageFileType;
			$signature_file = $target_dir . $imageName;
			move_uploaded_file($_FILES["SignatureUpload"]["tmp_name"], $target_dir . $imageName);

			//Add the Administrative Member
			$tempPass = $Member['EmailAddress']; #genPassword();

			$NewAdminMember = array(
			'MembershipNumber'=>$MembershipNumber,
			'Fullname'=>$Member['Fullname'],
			'AccId'=>genSysUserId(),
			'MSISDN'=>formatNumber($Member['MSISDN']),
			'EmailAddress'=>$Member['EmailAddress'],
			'ProfilePicture'=>$Member['ProfilePicture'],
			'Signature'=>$signature_file,
            'Password'=>password_hash($tempPass, PASSWORD_DEFAULT),
            'Role'=>$Role,
            'AccStatus'=>'Active',
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('systemusers', $NewAdminMember);
			$tID = DB::insertId();


			#Send the password via mail and sms
			$SMS = "Dear ".$Member['Fullname']." you have been assigned the role of ".$Designation." for Golden Team Savings and Investment Group. Login on: www.goldenteam.co.ug <br/> Email: ".$Member['EmailAddress']." and temporary password: ".$tempPass.". <br/> Change your password once logged in.".
			SendSms(formatNumber($Member['MSISDN']), $SMS, 'MEM - '.$tID, "SYSTEM");
			$_SESSION['Success'] = $Member['Fullname']." has been assigned the role of ".$Designation;
			header('Location: administrativeMembers.php');
		}
}

elseif($AdminAction == "Edit_Admin"){
	$UpdateDate = date('Y-m-d H:i:s');
	$Member = DB::queryFirstRow('SELECT * from systemusers where Id=%s', $EditMemID);

	//Image Edits
	$signature_file = basename($_FILES["SignatureUpload"]["name"]);
	if(empty($signature_file)){
		$signature_file = $Member['Signature'];
	}
	else{
		unlink($Member['Signature']);
		$imageFileType = strtolower(pathinfo($signature_file,PATHINFO_EXTENSION));
		$imageName = 'Signature-'.$Member['MembershipNumber'].'-'.str_replace(" ", "_", $Member['Fullname']).'.' . $imageFileType;
		$signature_file = $target_dir . $imageName;
		move_uploaded_file($_FILES["SignatureUpload"]["tmp_name"], $target_dir . $imageName);
	}


	if($Role == 4 && $AccStatus == "Inactive"){
		$_SESSION['Error'] = "Systems Administrator role cannot be Inactive";
	}
	else{
		$editSysMember = array(
			'Role'=>$Role,
			'AccStatus'=>$AccStatus,
			'Signature'=>$signature_file,
			'DateUpdated'=>$UpdateDate,
			);
			DB::update('systemusers', $editSysMember, 'Id=%s', $EditMemID);
			$_SESSION['Success'] = $Member['Fullname']."'s role has been updated Successfully";
	}
	
	header('Location: administrativeMembers.php');
}
else{
	//Delete the Record
	$query = DB::queryFirstRow('SELECT * from systemusers where Id=%s', $DelRowId);
	if($query['Role'] == 4){
		echo "Systems Administrator role cannot be Deleted";
	}
	else{
		DB::delete('systemusers', 'Id=%s', $DelRowId);
		echo $query['Fullname']."'s Administrative role has been removed.";
	}
}
?>
