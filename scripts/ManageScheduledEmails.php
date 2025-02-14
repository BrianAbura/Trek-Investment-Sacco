<?php 

/** Take Note of this */
//Fullpath required for email sending in production

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$scheduleEmailID = htmlspecialchars(( isset( $_REQUEST['scheduleEmailID'] ) )?  $_REQUEST['scheduleEmailID']: null);
$EmailSubject = htmlspecialchars(( isset( $_REQUEST['EmailSubject'] ) )?  $_REQUEST['EmailSubject']: null);
$EmailBody = ( isset( $_POST['EmailBody'] ) )?  $_POST['EmailBody']: null;

$scheduleDate = htmlspecialchars(( isset( $_REQUEST['scheduleDate'] ) )?  $_REQUEST['scheduleDate']: null);
$scheduleTime = htmlspecialchars(( isset( $_REQUEST['scheduleTime'] ) )?  $_REQUEST['scheduleTime']: null);

$target_dir = "../fileUploads/mailAttachments/"; //Fullpath required for email sending in production

//Some Edit
$schedule = date_format(date_create($scheduleDate.$scheduleTime),"Y-m-d H:i:s");
$Timestamp = date('YmdHis');
$UpdateDate = date('Y-m-d H:i:s');

$queryEmail = DB::queryFirstRow('SELECT * from scheduledemails where Id=%s', $scheduleEmailID);

        //Check the images properties
        $target_file = basename($_FILES["EmailAttachment"]["name"]);
        if(empty($target_file)){
            $target_file = $queryEmail['Attachments'];
        }
        else{
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
                header("Location:scheduledEmail.php");
                exit();
            }
            else{
                $imageName = 'Attachment-'.$EmailSubject.'-'.$Timestamp.'.' . $imageFileType;
                $target_file = $target_dir . $imageName;
                move_uploaded_file($_FILES["EmailAttachment"]["tmp_name"], $target_dir . $imageName);
            }
        }

        $editSchedule = array(
        'Subject'=>$EmailSubject,
        'Message'=>$EmailBody,
        'Attachments'=>$target_file,
        'Schedule'=>$schedule,
        'DateUpdated'=>$UpdateDate
        );
        DB::update('scheduledemails', $editSchedule, 'Id=%s', $scheduleEmailID);
        $_SESSION['Success'] = "Email schedule has been updated Successfully."; 
        
        header("Location:scheduledEmail.php");  
?>