<?php
date_default_timezone_set('Africa/Nairobi');
require_once('meekrodb.2.3.class.php');
require_once('Logger.php');

define( 'LOG_FILE', '/var/log/Trekinvestment/Trekinvestment.log');

define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'AburaDB' );
define( 'DB_PASS', '24@DBpass73' ); 
define( 'DB_NAME', 'trek_investment' );

/** SMS */
define( 'SMS_URL', 'https://www.lyptustech.com/lyptus-api/sms/' );
define( 'SMS_USER', 'T-REK-SMS_1001' );
define( 'SMS_PASS', 'LPYT_R3K-SMS_9876' );
define( 'CLIENT_ID', '29575' );

/** EMAIL */
define( 'EMAIL_URL', 'https://www.lyptustech.com/lyptus-api/email/' );
define( 'EMAIL_USER', 'T-REK-EMAIL-1002-001' );
define( 'EMAIL_PASS', 'LPYT_TR3K-EMAIL-1001-985' );

DB::$user = DB_USER;
DB::$password = DB_PASS;
DB::$dbName = DB_NAME;
DB::$host = DB_HOST;
?>
