<?php 
#Manage the Savings from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$SavingAction = htmlspecialchars(( isset( $_REQUEST['SavingAction'] ) )?  $_REQUEST['SavingAction']: null);
$EditSavingsId = htmlspecialchars(( isset( $_REQUEST['EditSavingsId'] ) )?  $_REQUEST['EditSavingsId']: null);

$SavingsId = genSavId();
$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$SavingMode = htmlspecialchars(( isset( $_REQUEST['SavingMode'] ) )?  $_REQUEST['SavingMode']: null);
$SavingDate = htmlspecialchars(( isset( $_REQUEST['SavingDate'] ) )?  $_REQUEST['SavingDate']: null);
$ReceiptNumber = htmlspecialchars(( isset( $_REQUEST['ReceiptNumber'] ) )?  $_REQUEST['ReceiptNumber']: null);
$NarrationMonth = htmlspecialchars(( isset( $_REQUEST['NarrationMonth'] ) )?  $_REQUEST['NarrationMonth']: null);
$NarrationYear = htmlspecialchars(( isset( $_REQUEST['NarrationYear'] ) )?  $_REQUEST['NarrationYear']: null);
$target_dir = "../fileUploads/receipts/";

#Some Edits
$Narration = "Saving for: ".$NarrationMonth." ".$NarrationYear;
$Amount = str_replace(',','', $Amount);
$SavingDate = date_format(date_create($SavingDate),"Y-m-d");
$ReceiptNumber = strtoupper($ReceiptNumber);


if($SavingAction == "Add_New_Savings"){
	$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
	$Fullname = $Member['Fullname'];

	$CheckSaving = DB::queryFirstRow('SELECT sum(Amount) from savings where MembershipNumber=%s AND Narration=%s', $MembershipNumber, $Narration);
	var_dump($CheckSaving);
	if($CheckSaving['sum(Amount)'] == 200000){
		$_SESSION['Error'] = $Fullname."'s ".$Narration." already exists.";
	}
	else{
		//Adding the ReceiptImage
		//Check the Profile Picture properties
		$target_file = basename($_FILES["ReceiptImage"]["name"]);
		if(empty($target_file)){
			$target_file = "";
		}
		else{
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
				$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
				header("Location:savings.php");
				exit();
			}
			else{
				$imageName = 'Savings-'.$SavingsId.'-'.$MembershipNumber.'.' . $imageFileType;
				$target_file = $target_dir . $imageName;
				move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
			}
		}

		//Add the Saving
			$NewSaving = array(
			'SavingsId'=>$SavingsId,
			'MembershipNumber'=>$MembershipNumber,
			'Amount'=>$Amount,
			'SavingMode'=>$SavingMode,
			'SavingDate'=>$SavingDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('savings', $NewSaving);
			
			//Send the Notifications.
			$TableId = "SV - ".DB::insertId();
			$TotalSavings = DB::queryFirstRow('SELECT sum(Amount) from savings where MembershipNumber=%s', $MembershipNumber);
			$SMS = "Your Saving to TREK of UGX ".number_format($Amount)." for the month of ".$NarrationMonth.", ".$NarrationYear." has been received and credited onto your account. Your total savings balance is UGX ".number_format($TotalSavings['sum(Amount)']);
			SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");

			#Check New Balances
			$query = DB::queryFirstRow('SELECT sum(Amount) from savings where Narration=%s and MembershipNumber=%s', $Narration, $MembershipNumber);
			$Balance = 200000 - $query['sum(Amount)'];
			if($Balance !=0){
				$_SESSION['Success'] = $Fullname."'s " .$Narration." of UGX".number_format($Amount)." has been captured Successfully. <br/> Balance on ".$Narration." is UGX".number_format($Balance);
			}
			else{
				$_SESSION['Success'] = $Fullname."'s " .$Narration." has been captured Successfully.";
			}
		}
		header('Location: savings.php');
	}
	elseif($SavingAction == "Edit_Saving"){
	
		$UpdateDate = date('Y-m-d H:i:s');
		$Timestamp = date('YmdHis');
		$savings = DB::queryFirstRow('SELECT * from savings where SavingsId=%s', $EditSavingsId);
		$Narration = "Saving for: ".$NarrationMonth." ".$NarrationYear;
		
		
		$Fullname = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $savings['MembershipNumber']);
		$Fullname = $Fullname['Fullname'];
	
		$CheckSaving = DB::query('SELECT Narration from savings where MembershipNumber=%s AND Narration=%s', $savings['MembershipNumber'], $Narration);
		$count = DB::count();

		if($count > 1){
			$_SESSION['Error'] = $Fullname." ".$Narration." already exists.";
			echo "Exists";
		}
		else{ //Normal Updates
				
			//Check properties of the Image. If Changed or Now
			$target_file = basename($_FILES["ReceiptImage"]["name"]);
			if(empty($target_file)){
				$target_file = $savings['ReceiptImage'];
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location: savings.php");
					exit();
				}
				else{
					$imageName = 'Savings-'.$EditSavingsId.'-'.$savings['MembershipNumber'].'_'.$Timestamp.'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
				}
			}

			$EditSaving = array(
			'Amount'=>$Amount,
			'SavingMode'=>$SavingMode,
			'SavingDate'=>$SavingDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'DateUpdated'=>$UpdateDate,
			);
			
			DB::update('savings', $EditSaving, 'SavingsId=%s', $EditSavingsId);
			$_SESSION['Success'] = $Fullname."'s " .$Narration." has been updated Successfully.";
		}
		header('Location: savings.php');
	}	
?>