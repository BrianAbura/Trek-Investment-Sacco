<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$ActionType = htmlspecialchars(( isset( $_REQUEST['ActionType'] ) )?  $_REQUEST['ActionType']: null);
$sysRole = htmlspecialchars(( isset( $_REQUEST['sysRole'] ) )?  $_REQUEST['sysRole']: null); #RoleID
$sysMember = htmlspecialchars(( isset( $_REQUEST['sysMember'] ) )?  $_REQUEST['sysMember']: null); #RoleID

$AccId = genSysUserId();

$member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $sysMember);
$Fullname = $member['Fullname'];

if($ActionType == "ADD"){
    //Add New Admin
    #Check if Member Already has that role
    $query = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s', $member['EmailAddress']);
    $Role = DB::queryFirstRow("SELECT Designation from roles where RoleId=%s", $sysRole);

    if($query){
        $_SESSION['Error'] = $Fullname." has already been assigned a role in the system.";
    }
    else{
        $tempPass = $member['EmailAddress'];
        $AddMember = array(
        'AccId'=>$AccId,
        'Fullname'=>$Fullname,
        'MSISDN'=>$member['MSISDN'],
        'EmailAddress'=>$member['EmailAddress'],
        'ProfilePicture'=>$member['ProfilePicture'],
        'Password'=>password_hash($tempPass, PASSWORD_DEFAULT),
        'Role'=>$sysRole,
        'CreatedBy'=>$CreatedBy,
        );
        DB::insert('systemusers',$AddMember);
        $tID = DB::insertId();

        $SMS = "You have been assigned the role of ".$Role['Designation']." for Trek Investment Club. Login on: https://trekinvestment.com/ <br/> Email: ".$member['EmailAddress']." and temporary password: ".$tempPass.". <br/> Change your password once logged in.";
        SendSms(formatNumber($member['MSISDN']), $SMS, 'SYS - '.$tID, "SYSTEM");
        $_SESSION['Success'] = $Fullname." has been assigned the role of ".$Role['Designation'];
    }
    header('Location: sysAdmin.php');
}
elseif($ActionType == "EDIT"){
    //Edit the Current Role
    #Can Also Deactivate/Activate with the Edit
    
}
elseif($ActionType == "REMOVE"){
    //Remove User
}
else{
    //Wait for Further Actions
}

?>