<?php 
#Manage the Welfare from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$WelfareAction = htmlspecialchars(( isset( $_REQUEST['WelfareAction'] ) )?  $_REQUEST['WelfareAction']: null);
$EditWelfareId = htmlspecialchars(( isset( $_REQUEST['EditWelfareId'] ) )?  $_REQUEST['EditWelfareId']: null);

$WelfareId = genWelfId();
$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$PaymentMode = htmlspecialchars(( isset( $_REQUEST['PaymentMode'] ) )?  $_REQUEST['PaymentMode']: null);
$PaymentDate = htmlspecialchars(( isset( $_REQUEST['PaymentDate'] ) )?  $_REQUEST['PaymentDate']: null);
$ReceiptNumber = htmlspecialchars(( isset( $_REQUEST['ReceiptNumber'] ) )?  $_REQUEST['ReceiptNumber']: null);
$NarrationMonth = htmlspecialchars(( isset( $_REQUEST['NarrationMonth'] ) )?  $_REQUEST['NarrationMonth']: null);
$NarrationYear = htmlspecialchars(( isset( $_REQUEST['NarrationYear'] ) )?  $_REQUEST['NarrationYear']: null);
$target_dir = "../fileUploads/receipts/";

#Some Edits
$Narration = "Welfare for: ".$NarrationMonth." ".$NarrationYear;
$Amount = str_replace(',','', $Amount);
$PaymentDate = date_format(date_create($PaymentDate),"Y-m-d");
$ReceiptNumber = strtoupper($ReceiptNumber);


if($WelfareAction == "Add_New_Welfare"){
	$Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MembershipNumber);
	$Fullname = $Member['Fullname'];

	$CheckWelfare = DB::queryFirstRow('SELECT sum(Amount) from welfare where MembershipNumber=%s AND Narration=%s', $MembershipNumber, $Narration);
	var_dump($CheckWelfare);
	if($CheckWelfare['sum(Amount)'] == 50000){
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
				$imageName = 'Welfare-'.$WelfareId.'-'.$MembershipNumber.'.' . $imageFileType;
				$target_file = $target_dir . $imageName;
				move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
			}
		}

		//Add the Saving
			$NewWelfare = array(
			'WelfareId'=>$WelfareId,
			'MembershipNumber'=>$MembershipNumber,
			'Amount'=>$Amount,
			'PaymentMode'=>$PaymentMode,
			'PaymentDate'=>$PaymentDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('welfare', $NewWelfare);
			
			//Send the Notifications.
			$TableId = "WF - ".DB::insertId();
			$TotalWelfare = DB::queryFirstRow('SELECT sum(Amount) from welfare where MembershipNumber=%s', $MembershipNumber);
			$SMS = "Your Welfare to TREK of UGX ".number_format($Amount)." for the month of ".$NarrationMonth.", ".$NarrationYear." has been received and credited onto your account. Your total welfare balance is UGX ".number_format($TotalWelfare['sum(Amount)']);
			SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");

			#Check New Balances
			$query = DB::queryFirstRow('SELECT sum(Amount) from welfare where Narration=%s and MembershipNumber=%s', $Narration, $MembershipNumber);
			$Balance = 50000 - $query['sum(Amount)'];
			if($Balance !=0){
				$_SESSION['Success'] = $Fullname."'s " .$Narration." of UGX".number_format($Amount)." has been captured Successfully. <br/> Balance on ".$Narration." is UGX".number_format($Balance);
			}
			else{
				$_SESSION['Success'] = $Fullname."'s " .$Narration." has been fully captured Successfully.";
			}
		}
		header('Location: welfare.php');
	}
	elseif($WelfareAction == "Edit_Welfare"){

		$UpdateDate = date('Y-m-d H:i:s');
		$Timestamp = date('YmdHis');
		$Welfare = DB::queryFirstRow('SELECT * from welfare where WelfareId=%s', $EditWelfareId);
		$Narration = "Welfare for: ".$NarrationMonth." ".$NarrationYear;
		
		$Fullname = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $Welfare['MembershipNumber']);
		$Fullname = $Fullname['Fullname'];
		
		if($Welfare['Narration'] != $Narration){
			$CheckWelfare = DB::queryFirstRow('SELECT Narration from welfare where MembershipNumber=%s AND Narration=%s', $Welfare['MembershipNumber'], $Narration);
			if(isset($CheckWelfare['Narration'])){
				$_SESSION['Error'] = $Fullname." ".$Narration." already exists.";
			}
		}
		else{ //Normal Updates
				
			//Check properties of the Image. If Changed or Now
			$target_file = basename($_FILES["ReceiptImage"]["name"]);
			if(empty($target_file)){
				$target_file = $Welfare['ReceiptImage'];
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location: welfare.php");
					exit();
				}
				else{
					$imageName = 'Welfare-'.$EditWelfareId.'-'.$Welfare['MembershipNumber'].'_'.$Timestamp.'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
				}
			}

			$EditWelfare = array(
			'Amount'=>$Amount,
			'PaymentMode'=>$PaymentMode,
			'PaymentDate'=>$PaymentDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'DateUpdated'=>$UpdateDate,
			);
			DB::update('welfare', $EditWelfare, 'WelfareId=%s', $EditWelfareId);
			$_SESSION['Success'] = $Fullname."'s " .$Narration." has been updated Successfully.";
		}
		header('Location: welfare.php');
	}	
?>
