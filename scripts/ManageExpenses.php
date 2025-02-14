<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$expenseType = htmlspecialchars(( isset( $_REQUEST['expenseType'] ) )?  $_REQUEST['expenseType']: null);
$expenseID = htmlspecialchars(( isset( $_REQUEST['expenseID'] ) )?  $_REQUEST['expenseID']: null);

$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);
$target_dir = "../fileUploads/receipts/";

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");
$Timestamp = date('YmdHis'); //For the Attachment

if($expenseType == "ADD"){
  
    //Check the Profile Picture properties
		$target_file = basename($_FILES["ReceiptImage"]["name"]);
		if(empty($target_file)){
			$target_file = "";
		}
		else{
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
				$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
				header("Location:expenses.php");
				exit();
			}
			else{
				$imageName = 'Expenses-'.$Timestamp.'.' . $imageFileType;
				$target_file = $target_dir . $imageName;
				move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
			}
		}

        $NewExpense = array(
        'Amount'=>$Amount,
        'Narration'=>$Narration,
        'TransactionDate'=>$transaction_date,
        'ReceiptImage'=>$target_file,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('expenses', $NewExpense);
        $_SESSION['Success'] = "Expense of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
        header('Location:expenses.php');
    }
elseif($expenseType == "EDIT"){
    $UpdateDate = date('Y-m-d H:i:s');

        $expense = DB::queryFirstRow('SELECT * from expenses where Id=%s', $expenseID);
        $target_file = basename($_FILES["ReceiptImage"]["name"]);
        if(empty($target_file)){
            $target_file = $expense['ReceiptImage'];
        }
        else{
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
                header("Location:expenses.php");
                exit();
            }
            else{
                $imageName = 'Expenses-'.$Timestamp.'.' . $imageFileType;
                $target_file = $target_dir . $imageName;
                move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
            }
        }

    $EditExpense = array(
    'Amount'=>$Amount,
    'Narration'=>$Narration,
    'TransactionDate'=>$transaction_date,
    'ReceiptImage'=>$target_file,
    'DateUpdated'=>$UpdateDate,
    );
    
    DB::update('expenses', $EditExpense, 'Id=%s', $expenseID);
    $_SESSION['Success'] = "Expense of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    header('Location:expenses.php');
}
?>