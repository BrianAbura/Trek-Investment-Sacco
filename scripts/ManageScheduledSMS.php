<?php 
//Manage SMS's from here.
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$scheduleSMSID = htmlspecialchars(( isset( $_REQUEST['scheduleSMSID'] ) )?  $_REQUEST['scheduleSMSID']: null);
$SMSmessage = htmlspecialchars(( isset( $_REQUEST['SMSmessage'] ) )?  $_REQUEST['SMSmessage']: null);

$scheduleDate = htmlspecialchars(( isset( $_REQUEST['scheduleDate'] ) )?  $_REQUEST['scheduleDate']: null);
$scheduleTime = htmlspecialchars(( isset( $_REQUEST['scheduleTime'] ) )?  $_REQUEST['scheduleTime']: null);

//Some Edit
$schedule = date_format(date_create($scheduleDate.$scheduleTime),"Y-m-d H:i:s");
$UpdateDate = date('Y-m-d H:i:s');

    $editSchedule = array(
    'Message'=>trim($SMSmessage),
    'Schedule'=>$schedule,
    'Status'=>'Scheduled',
    'DateUpdated'=>$UpdateDate
    );
    DB::update('scheduledsms', $editSchedule, 'Id=%s', $scheduleSMSID);
    $_SESSION['Success'] = "SMS schedule has been updated Successfully."; 
    
    header("Location:scheduledSMS.php");  
?>