<?php 
//Adding New member

require_once('../defines.php');
require_once('../validate.php');
require_once('functions.php');


$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);

DB::delete('members', "AccNumber=%s", $AccNumber);
DB::delete('savings', "AccNumber=%s", $AccNumber);
echo "Member has been deleted from the system.";
?>