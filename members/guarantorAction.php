<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$GuarantorId = htmlspecialchars(( isset( $_REQUEST['GuarantorId'] ) )?  $_REQUEST['GuarantorId']: null);
$Status = htmlspecialchars(( isset( $_REQUEST['Status'] ) )?  $_REQUEST['Status']: null);
$Comments = htmlspecialchars(( isset( $_REQUEST['Comments'] ) )?  $_REQUEST['Comments']: null);

    $GurantAction = array(
    'Status'=>$Status,
    'Comments'=>$Comments,
    );

    DB::update('guarantors', $GurantAction, 'Id=%s', $GuarantorId);
    echo "Your response has been successfully captured."
?>
