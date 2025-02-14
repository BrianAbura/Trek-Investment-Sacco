<?php 

/** Take Note of this */
//Fullpath required for email sending in production

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$SelectMemberNum = ( isset( $_REQUEST['SelectMemberNum'] ) )?  $_REQUEST['SelectMemberNum']: null;
$EmailSubject = htmlspecialchars(( isset( $_REQUEST['EmailSubject'] ) )?  $_REQUEST['EmailSubject']: null);
$EmailBody = ( isset( $_POST['EmailBody'] ) )?  $_POST['EmailBody']: null;

$scheduleChecker = htmlspecialchars(( isset( $_REQUEST['scheduleChecker'] ) )?  $_REQUEST['scheduleChecker']: null);
$scheduleDate = htmlspecialchars(( isset( $_REQUEST['scheduleDate'] ) )?  $_REQUEST['scheduleDate']: null);
$scheduleTime = htmlspecialchars(( isset( $_REQUEST['scheduleTime'] ) )?  $_REQUEST['scheduleTime']: null);

$target_dir = "../fileUploads/mailAttachments/"; //Fullpath required for email sending in production

//Some Edit
$schedule = date_format(date_create($scheduleDate.$scheduleTime),"Y-m-d H:i:s");
$date = date('Y-m-d H:i:s');
$Timestamp = date('YmdHis');

        //Check the images properties
        $target_file = basename($_FILES["EmailAttachment"]["name"]);
        if(empty($target_file)){
            $target_file = "";
        }
        else{
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
                header("Location:email.php");
                exit();
            }
            else{
                $imageName = 'Attachment-'.$EmailSubject.'-'.$Timestamp.'.' . $imageFileType;
                $target_file = $target_dir . $imageName;
                move_uploaded_file($_FILES["EmailAttachment"]["tmp_name"], $target_dir . $imageName);
            }
        }

if($scheduleChecker == "SET"){ //Scheduled Emails
    foreach($SelectMemberNum as $memEmail){
        if($memEmail == "ALL"){
            $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
            foreach($members as $member){
                $emailSchedule = array(
                    'ReceiverName'=>$member['Fullname'],
                    'ReceiverEmail'=>$member['EmailAddress'],
                    'Subject'=>$EmailSubject,
                    'Message'=>$EmailBody,
                    'Attachments'=>$target_file,
                    'Schedule'=>$schedule,
                    'CreatedBy'=>$CreatedBy
                );
                DB::insert('scheduledemails', $emailSchedule);
            }
        }
        else{
            $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $memEmail);
                $emailSchedule = array(
                    'ReceiverName'=>$member['Fullname'],
                    'ReceiverEmail'=>$member['EmailAddress'],
                    'Subject'=>$EmailSubject,
                    'Message'=>$EmailBody,
                    'Attachments'=>$target_file,
                    'Schedule'=>$schedule,
                    'CreatedBy'=>$CreatedBy
                );
                DB::insert('scheduledemails', $emailSchedule);
        }
    }
    $_SESSION['Success'] = "Email schedule has been saved. Emails(s) will be sent as per the schedule.";
    header("Location:scheduledEmail.php");
}
else{// Direct Send
    foreach($SelectMemberNum as $memEmail){
        if($memEmail == "ALL"){
            $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
            foreach($members as $member){
                $Receipient = array(
                    'Fullname' => $member['Fullname'],
                    'EmailAddress' => $member['EmailAddress']
                );
                $message = array(
                    'MsgBody' => $EmailBody,
                    'MsgAttachment' => $target_file
                );                
                SendEmail('EMAILS', $EmailSubject, $Receipient, $message, $CreatedBy);
            }
        }
        else{
            $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $memEmail);
                $Receipient = array(
                    'Fullname' => $member['Fullname'],
                    'EmailAddress' => $member['EmailAddress']
                );
                $message = array(
                    'MsgBody' => $EmailBody,
                    'MsgAttachment' => $target_file
                );                
                SendEmail('Email-TB', $EmailSubject, $Receipient, $message, $CreatedBy);
        }
    }
       
    $_SESSION['Success'] = "Email is being processed.";
    header("Location:email.php");
}

?>