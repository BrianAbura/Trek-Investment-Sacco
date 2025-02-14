<?php 
//Manage SMS's from here.
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$SMSMember = ( isset( $_REQUEST['SMSMember'] ) )?  $_REQUEST['SMSMember']: null;
$SMSmessage = htmlspecialchars(( isset( $_REQUEST['SMSmessage'] ) )?  $_REQUEST['SMSmessage']: null);

$scheduleChecker = htmlspecialchars(( isset( $_REQUEST['scheduleChecker'] ) )?  $_REQUEST['scheduleChecker']: null);
$scheduleDate = htmlspecialchars(( isset( $_REQUEST['scheduleDate'] ) )?  $_REQUEST['scheduleDate']: null);
$scheduleTime = htmlspecialchars(( isset( $_REQUEST['scheduleTime'] ) )?  $_REQUEST['scheduleTime']: null);

//Some Edit
$schedule = date_format(date_create($scheduleDate.$scheduleTime),"Y-m-d H:i:s");

//Resend SMS
$token = ( isset( $_REQUEST['token'] ) )?  $_REQUEST['token']: null;
$sms_id = ( isset( $_REQUEST['sms_id'] ) )?  $_REQUEST['sms_id']: null;


if($scheduleChecker == "SET"){
    foreach($SMSMember as $numbers){
        if($numbers == "ALL"){
            $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
            foreach($members as $member){
                $smsSchedule = array(
                    'MSISDN'=>$member['MSISDN'],
                    'Message'=>trim($SMSmessage),
                    'Schedule'=>$schedule,
                    'Status'=>'Scheduled',
                    'CreatedBy'=>$CreatedBy
                );
                DB::insert('scheduledsms', $smsSchedule);
            }
        }
        else{
            $smsSchedule = array(
                'MSISDN'=>$numbers,
                'Message'=>trim($SMSmessage),
                'Schedule'=>$schedule,
             	'Status'=>'Scheduled',
                'CreatedBy'=>$CreatedBy
            );
            DB::insert('scheduledsms', $smsSchedule);
        }
    }
        //Schedul
        $_SESSION['Success'] = "SMS schedule has been saved. Message(s) will be sent as per the schedule.";
        header('Location: scheduledSMS.php');
}
elseif($token == "resend_sms"){
    //Resend Where they failed
    $sent = DB::queryFirstRow('SELECT * from smsnotice where Id=%s', $sms_id);
    $response = send_notice($sent['MSISDN'], trim($sent['Message']));
    DB::update('smsnotice', array('Response'=>$response), 'Id=%s', $sms_id);
    $_SESSION['Success'] =  "SMS Message has been resent.";
    header('Location: sms.php');
}
else{
    //Send Direct
    foreach($SMSMember as $numbers){
        if($numbers == "ALL"){
            $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
            foreach($members as $member){
                DB::insert('smsnotice', array('TableId'=>'SMS-ADMIN', 'MSISDN'=>$member['MSISDN'], 'Message'=>trim($SMSmessage), 'CreatedBy'=>$CreatedBy));
                $id = DB::insertId();
                $response = send_notice($member['MSISDN'], trim($SMSmessage));
                DB::update('smsnotice', array('Response'=>$response), 'Id=%s', $id);
            }
        }
        else{
            DB::insert('smsnotice', array('TableId'=>'SMS-ADMIN', 'MSISDN'=>$numbers, 'Message'=>trim($SMSmessage), 'CreatedBy'=>$CreatedBy));
            $id = DB::insertId();
            $response = send_notice($numbers, trim($SMSmessage));
            DB::update('smsnotice', array('Response'=>$response), 'Id=%s', $id);
        }
    }
    $_SESSION['Success'] =  "SMS Message(s) has been sent.";
    header('Location: sms.php');
}

?>