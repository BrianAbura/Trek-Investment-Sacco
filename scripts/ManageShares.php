<?php 
#Manage the Shares from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$sharesAction = htmlspecialchars(( isset( $_REQUEST['sharesAction'] ) )?  $_REQUEST['sharesAction']: null);

$shareID = htmlspecialchars(( isset( $_REQUEST['shareID'] ) )?  $_REQUEST['shareID']: null);
$MembershipNumber = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
$Member_Shares = htmlspecialchars(( isset( $_REQUEST['Member_Shares'] ) )?  $_REQUEST['Member_Shares']: null);
$Share_Value = htmlspecialchars(( isset( $_REQUEST['share_value'] ) )?  $_REQUEST['share_value']: null);
$purchase_date = htmlspecialchars(( isset( $_REQUEST['purchase_date'] ) )?  $_REQUEST['purchase_date']: null);

//# Some Edits
$Member_Shares = str_replace(',','', $Member_Shares);
$Share_Value = str_replace(',','', $Share_Value);
$purchase_date = date_format(date_create($purchase_date),"Y-m-d");

$Fullname = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $MembershipNumber);
$Fullname = $Fullname['Fullname'];

if($sharesAction == "AddShares"){
//Add the Shares
    $AddMemShares = array(
    'MembershipNumber'=>$MembershipNumber,
    'SharesPurchased'=>$Member_Shares,
    'ShareValue'=>$Share_Value,
    'PurchaseDate'=>$purchase_date,
    'AddedBy'=>$CreatedBy,
    );
    
    DB::insert('shares', $AddMemShares);
    $_SESSION['Success'] = $Fullname." has purchased ".$Member_Shares." share(s) at UGX ".$Share_Value." each.";
}
elseif($sharesAction == "EditShares"){
    $UpdateDate = date('Y-m-d H:i:s');

    $shares = DB::queryFirstRow('SELECT * from shares where Id=%s', $shareID);
    $Fullname = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s', $shares['MembershipNumber']);
	$Fullname = $Fullname['Fullname'];

    $EditMemShares = array(
    'SharesPurchased'=>$Member_Shares,
    'ShareValue'=>$Share_Value,
    'PurchaseDate'=>$purchase_date,
    'DateUpdated'=>$UpdateDate,
    );
    DB::update('shares', $EditMemShares, 'Id=%s', $shareID);
    $_SESSION['Success'] = $Fullname."'s share record has been updated Successfully ";
}

header('Location: shares.php');

?>