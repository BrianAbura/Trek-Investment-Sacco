<?php 
//Adding New member
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$MemAction = htmlspecialchars(( isset( $_REQUEST['MemAction'] ) )?  $_REQUEST['MemAction']: null);
$EditMemID = htmlspecialchars(( isset( $_REQUEST['EditMemID'] ) )?  $_REQUEST['EditMemID']: null);

$MembershipNumber = genMemNum();
$Fullname = htmlspecialchars(( isset( $_REQUEST['Name'] ) )?  $_REQUEST['Name']: null);
$EmailAddress = htmlspecialchars(( isset( $_REQUEST['EmailAddress'] ) )?  $_REQUEST['EmailAddress']: null);
$MSISDN = htmlspecialchars(( isset( $_REQUEST['MSISDN'] ) )?  $_REQUEST['MSISDN']: null);
$IDNum = htmlspecialchars(( isset( $_REQUEST['IDNum'] ) )?  $_REQUEST['IDNum']: null);
$Workplace = htmlspecialchars(( isset( $_REQUEST['Workplace'] ) )?  $_REQUEST['Workplace']: null);
$Residence = htmlspecialchars(( isset( $_REQUEST['Residence'] ) )?  $_REQUEST['Residence']: null);
$Postal_Address = htmlspecialchars(( isset( $_REQUEST['Postal_Address'] ) )?  $_REQUEST['Postal_Address']: null);
$joining_date = htmlspecialchars(( isset( $_REQUEST['joining_date'] ) )?  $_REQUEST['joining_date']: null);
$Member_Shares = htmlspecialchars(( isset( $_REQUEST['Member_Shares'] ) )?  $_REQUEST['Member_Shares']: null);
$Share_Value = htmlspecialchars(( isset( $_REQUEST['share_value'] ) )?  $_REQUEST['share_value']: null);
$target_dir = "../fileUploads/profiles/";

//Format Some Inputs
$Member_Shares = str_replace(',','', $Member_Shares);
$Share_Value = str_replace(',','', $Share_Value);
$joining_date = date_format(date_create($joining_date),"Y-m-d");

if($MemAction == "Add_MEM"){

		//Check Email Availability
		if(CheckEmail($EmailAddress)){
			$_SESSION['Error'] = "The Email Address already exists.";
			header('Location: allMembers.php');
			exit();
		}
		else{
			//Adding the ProfilePicture
			//Check the Profile Picture properties
			$target_file = basename($_FILES["ProfilePicture"]["name"]);
			if(empty($target_file)){
				 $target_file = "../dist/img/avatar.png";
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location:allMembers.php");
					exit();
				}
				else{
					$imageName = 'ProfilePicture-'.$MembershipNumber.'-'.str_replace(" ", "_", $Fullname).'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ProfilePicture"]["tmp_name"], $target_dir . $imageName);
				}
			}

			//Add the Member
			$tempPass = $EmailAddress; #genPassword();
			$NewMember = array(
			'MembershipNumber'=>$MembershipNumber,
			'Fullname'=>$Fullname,
			'Joining_date'=>$joining_date,
			'MSISDN'=>formatNumber($MSISDN),
			'EmailAddress'=>$EmailAddress,
			'Workplace'=>$Workplace,
			'IDNum'=>$IDNum,
			'Residence'=>$Residence,
			'Postal_Address'=>$Postal_Address,
			'ProfilePicture'=>$target_file,
			'Password'=>password_hash($tempPass, PASSWORD_DEFAULT),
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('members', $NewMember);
			$tID = DB::insertId();

			//Add the Shares
				if(($Member_Shares !=0) || ($Share_Value !=0)){
				$MemberShares = array(
				'MembershipNumber'=>$MembershipNumber,
				'SharesPurchased'=>$Member_Shares,
				'ShareValue'=>$Share_Value,
				'AddedBy'=>$CreatedBy,
				);
				DB::insert('shares', $MemberShares);
			}

			#Send the password via mail and sms
			$SMS = "Dear ".$Fullname." your account has been created on TREK Investment Club. Login on: www.trekinvest.com <br/> Email: ".$EmailAddress." and temporary password: ".$tempPass.". <br/> Change your password once logged in.";
			SendSms(formatNumber($MSISDN), $SMS, 'MEM - '.$tID, "SYSTEM");
			$_SESSION['Success'] = $Fullname." has been SUCCESSFULLY added.";
			header('Location: allMembers.php');
		}
}

elseif($MemAction == "Edit_MEM"){		/** Editing Existing Member of the Sacco via the Form **/
	
	$UpdateDate = date('Y-m-d H:i:s');
	$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $EditMemID);
	$timeStamp = date('YmdHis');


	//Check properties of the Profile Picture
	$target_file = basename($_FILES["ProfilePicture"]["name"]);
	if(empty($target_file)){
		$target_file = $Member['ProfilePicture'];
	}
	else{
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
			header("Location:memberProfile.php?MembershipNumber=".$EditMemID);
			exit();
		}
		else{
			$imageName = 'ProfilePicture-'.$EditMemID.'-'.str_replace(" ", "_", $Fullname).'_'.$timeStamp.'.' . $imageFileType;
			$target_file = $target_dir . $imageName;
			move_uploaded_file($_FILES["ProfilePicture"]["tmp_name"], $target_dir . $imageName);
			if(file_exists($Member['ProfilePicture'])){
				unlink($Member['ProfilePicture']);
			  }
		}
	}

		$EditMember = array(
		'Fullname'=>$Fullname,
		'Joining_date'=>$joining_date,
		'MSISDN'=>formatNumber($MSISDN),
		'EmailAddress'=>$EmailAddress,
		'Workplace'=>$Workplace,
		'IDNum'=>$IDNum,
		'Residence'=>$Residence,
		'Postal_Address'=>$Postal_Address,
		'ProfilePicture'=>$target_file,
		'DateUpdated'=>$UpdateDate,
		);
		
		try {
			DB::update('members', $EditMember, 'MembershipNumber=%s', $EditMemID);
			echo "Updated";
		} 
		catch(MeekroDBException $e) {
			echo "The Membership Number: ".$EditMemID." is registered to another member";
		}

		$_SESSION['Success'] = $Fullname."'s information has been updated Successfully.";
		header("Location:memberProfile.php?MembershipNumber=".$EditMemID);
}
?>
