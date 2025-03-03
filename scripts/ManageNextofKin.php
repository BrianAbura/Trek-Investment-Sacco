<?php
#Manage the Next of Kin from here

require_once('../defines/functions.php');
require_once('../validate.php');

$MembershipNumber = htmlspecialchars((isset($_REQUEST['MembershipNumber'])) ?  $_REQUEST['MembershipNumber'] : null);
$kin_action = htmlspecialchars((isset($_REQUEST['kin_action'])) ?  $_REQUEST['kin_action'] : null);
$nok_id = htmlspecialchars((isset($_REQUEST['nok_id'])) ?  $_REQUEST['nok_id'] : null);

$Fullname = htmlspecialchars((isset($_REQUEST['Fullname'])) ?  $_REQUEST['Fullname'] : null);
$Phone_Number = htmlspecialchars((isset($_REQUEST['Phone_Number'])) ?  $_REQUEST['Phone_Number'] : null);
$Email_Address = htmlspecialchars((isset($_REQUEST['Email_Address'])) ?  $_REQUEST['Email_Address'] : null);
$Relationship = htmlspecialchars((isset($_REQUEST['Relationship'])) ?  $_REQUEST['Relationship'] : null);

if ($kin_action == "Create") {
    # Add Next of Kin
    $NewMember = array(
        'MembershipNumber' => $MembershipNumber,
        'Fullname' => $Fullname,
        'MSISDN' => $Phone_Number,
        'EmailAddress' => $Email_Address,
        'Relation' => $Relationship,
    );

    DB::insert('next_of_kin', $NewMember);
    $_SESSION['Success'] = "Next of Kin Saved Successfully.";
    header("Location:memberProfile.php?MembershipNumber=" . $MembershipNumber);
} elseif ($kin_action == "Edit") {

    $UpdateMember = array(
        'MembershipNumber' => $MembershipNumber,
        'Fullname' => $Fullname,
        'MSISDN' => $Phone_Number,
        'EmailAddress' => $Email_Address,
        'Relation' => $Relationship,
    );

    DB::update('next_of_kin', $UpdateMember, 'Id=%s', $nok_id);
    $_SESSION['Success'] = "Next of Kin Details updated Successfully.";
    header("Location:memberProfile.php?MembershipNumber=" . $MembershipNumber);
} else {
    // Delete
    DB::delete('next_of_kin', "Id=%s", $nok_id);
    $_SESSION['Success'] = "Next of Kin has been removed.";
    header("Location:memberProfile.php?MembershipNumber=" . $MembershipNumber);
}
