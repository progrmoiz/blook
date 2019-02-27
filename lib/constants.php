<?php

/* PRODUCTION database settings
define('DBNAME',   '');
define('HOSTNAME', '');
define('USERNAME', '');
define('PASSWORD', '');
//*/

//* LOCALHOST database settings
define('DBNAME',  'blook');
define('HOSTNAME','localhost');
define('USERNAME','root');
define('PASSWORD','');
//*/

define('CREDITS','<!--

+ * * * * * * * * * * * * * * * * * +
*         Your credits here         *
+ * * * * * * * * * * * * * * * * * +

-->');

define('SITE_NAME', 'Blook');
define('SITE_AUTHOR', 'Abdul Moiz');

// REFERENCE: http://it2.php.net/manual/en/function.date.php
define('YEAR',date('Y')); // Example: 2012, 1990
// define('NOW',time()); // the current timestamp (USE time() directly)
define('ONE_YEAR',	31556926); // one year in seconds
define('ONE_MONTH',	2629744); // one month in seconds
define('ONE_WEEK',	604800); // one week in seconds
define('ONE_DAY',	86400); // one day in seconds
define('ONE_HOUR',	3600); // one hour in seconds
define('ONE_MINUTE',60);  // one minute in seconds


// REFERENCE: http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date-format
define('DATE_FORMAT_DATETIME', '%d/%m/%Y %H:%i'); // prints: 25/04/2012 16:30
define('DATE_FORMAT_DATE', '%d/%m/%Y'); // prints: 25/04/2012
define('DATE_FORMAT_TIME', '%H:%i'); // prints: 16:30


// REFERENCE: http://php.net/manual/en/function.strftime.php
define('STRFTIME_DATETIME', '%A %d %B %Y &nbsp; %H:%M'); // prints: Lunedì 16 Aprile 2012   15:51

// for the date() function
define('MYSQL_DATETIME', "Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)

define('ANALYTICS_CODE', 'UA-XXX-X');

//*** LOCALHOST main paths ***
define('ROOT', 			'/project');
define('ABSOLUTE_ROOT', 'http://localhost/project/');
//*/

/*** internal paths / shortcuts ***/
define("ROOT_PATH",     realpath(__DIR__ . "/../"));
define('APP',			ROOT_PATH . '/app/');
define('LIB',			ROOT_PATH . '/lib/');
define('CLS',			ROOT_PATH . '/lib/class/');
define('TEMPLATE',      APP . 'templates/');
define('INC',	        APP . 'includes/');
define('BACKEND',       APP . 'backend/');
define('ACC',           APP . 'accounts/');