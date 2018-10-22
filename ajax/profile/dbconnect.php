<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ob_start();
session_start();

define('PROJECT_NAME', 'User Registration with Email Verification with PHP and Mysql- www.thesoftwareguy.in');

define('DB_DRIVER', 'mysql');
define('DBHOST', 'localhost');
define('DBUSER', 'clifford');
define('DBPASS', 'cliffkaka');
define('DBNAME', 'bext_system');

// must end with a slash
define('SITE_URL', 'http://localhost/bextsystem/register');

$conn = mysql_connect(DBHOST,DBUSER,DBPASS);
	$dbcon = mysql_select_db(DBNAME);
	
	if ( !$conn ) {
		die("Connection failed : " . mysql_error());
	}
	
	if ( !$dbcon ) {
		die("Database Connection failed : " . mysql_error());
	}

?>
