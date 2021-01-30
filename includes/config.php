<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING ));
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'pushNotification');
define('DB_HOST', 'localhost');
define('GCM_API_KEY', 'AAAAveFXrEc:APA91bF4UFyAmwYTuw9TTRPnLJUi1klYz-2DxmwrwhgzXxKwrFR9X-ayl5BwKig9HJGma732Fx8CM0eWmZa9wpV7Bu30GyqT5TQy4zm2r6inwAotRcygEQQ0Eg_2-2XZk6-q1sPLI_BB');
define('SITE_URL', 'https://example.com/');
$DBC =  mysqlConnect();
function mysqlConnect()
{
	return mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 	// Conecting to MySQL server using the defined constants
	// $DbConn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
	// if (!$DbConn) {
	// 	$DbError = 'Could not connect to mysql.';
	// } else {
	// 	if (defined('TZ_TIMEZONE')) {
	// 		$timeQry = "SET time_zone = '" . date('P') . "'";
	// 		mysqli_query($timeQry,$DbConn);
	// 	}
		
	// 	$selectDb = mysqli_select_db(DB_DATABASE, $DbConn);
	// 	if (!$selectDb) {
	// 		$DbError = 'Could not connect to database.';
	// 	}
	// }
}


?>