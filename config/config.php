<?php

/**
* config.php
*
* @package Framework
* @filesource
*/


define('SYSTEM_PAGE_TITLE', '');
define('DOMAIN_NAME', '');


/***************
  Mailer prefs
***************/

/**
* MAIL_FROM
*
* Mail From address to use when sending mail
*
* @global constant MAIL_FROM Mail From address
*/
define('MAIL_FROM', 'Mailer');

/**
* SMTP_USERNAME
*
* SMTP username to use when sending mail
*
* @global constant SMTP_USERNAME SMTP username
*/
define('SMTP_USERNAME', 'root@localhost.com');

/**
* SMTP_PASSWORD
*
* SMTP password to use when sending mail
*
* @global constant SMTP_PASSWORD SMTP password
*/
define('SMTP_PASSWORD', '123456');

/**
* SMTP_HOST
*
* SMTP host to use when sending mail
*
* @global constant SMTP_HOST SMTP password
*/
define('SMTP_HOST', 'localhost');

/**
* SENDMAIL_PATH
*
* Path to the sendmail binary
*
* @global constant SENDMAIL_PATH path to sendmail
*/
define('SENDMAIL_PATH', '/usr/sbin/sendmail');

/**
* DISPLAY_XPM4_ERRORS
*
* Display XPM4 Mailer errors?
*
* @global constant DISPLAY_XPM4_ERRORS Display mailer errors boolean
* @link http://xpertmailer.sourceforge.net/documentation/
*/
define('DISPLAY_XPM4_ERRORS', true);




/******************
  ReCaptcha prefs
******************/


/**
* RECAPTCHA_PRIVATE_KEY
*
* PRIVATE RECAPTCHA KEY TO USE WHEN COMMUNICATING WITH GOOGLE
*
* @global constant RECAPTCHA_PRIVATE_KEY
*/
define('RECAPTCHA_PRIVATE_KEY', 'googleCaptchaPrivateKey');

/**
* RECAPTCHA_PUBLIC_KEY
*
* PUBLIC RECAPTCHA KEY FOR USE IN HTML FORMS
*
* @global constant RECAPTCHA_PUBLIC_KEY
*/
define('RECAPTCHA_PUBLIC_KEY', 'googleCaptchaPublicKey');



/***************
  System prefs
***************/

/**
* DOMAIN_NAME
*
* The domain name of the server
*
* @global constant DOMAIN_NAME The server domain name
*/
define('DOMAIN_NAME', "www.domain.com");

/**
* SERVER_URI
*
* The server URI.
*
* @global constant SERVER_URI The server URI
*/
define('SERVER_URI', "http://".DOMAIN_NAME);

/**
* MAX_FILE_SIZE
*
* The maximum size (in bytes) permitted for uploaded files.
* Set to 0 for no limit
*
* @global constant MAX_FILE_SIZE The maximum uploadable filesize in bytes
*/
define('MAX_FILE_SIZE', 100000000); //100MB

/**
* SYSTEM_CORES
*
* The number of cores on the server.
*
* @global constant SYSTEM_CORES The number of cores on the server
*/
define('SYSTEM_CORES', 12);

/**
* LOAD_ALERT
*
* The load at which an alert is shown on pages.
*
* @global constant LOAD_ALERT The load at which an alert is shown on the *CAT pages
*/
define('LOAD_ALERT',  (SYSTEM_CORES * 0.66));


/**
* STORE_DATA_TIME
*
* How long, in seconds to store data for
* After this time, the data is automatically deleted by cron
*
* @global constant STORE_DATA_TIME The time in seconds to store data
*/
define("STORE_DATA_TIME", 60*60*24*2); // 2 Days



/*****************************************************
*   NOTHING SHOULD REQUIRE EDITING BELOW THIS LINE   *
******************************************************/

/**
* DS
* PS
*
* defines machine-specific seperators in shorthand
*
* @global constant DS The server directory separator
* @global constant PS The server path separator
*/
define('DS', DIRECTORY_SEPARATOR );
define('PS', PATH_SEPARATOR);


/**
* SYSTEM_DIRECTORY_ROOT
*
* Dynamically figure out where in the filesystem the directory root is located.
*
* @global constant SYSTEM_DIRECTORY_ROOT Absolute path to our framework
*/
define('SYSTEM_DIRECTORY_ROOT', str_replace('/config', '', dirname(__FILE__) ) );

/**
* SYSTEM_DOCUMENT_ROOT
*
* Dynamically figure out where in the filesystem the http document root is located.
* Note, we cannot reply on _SERVER['DOCUMENT_ROOT'] as this is not set when running from the CLI
*
* @global constant SYSTEM_DOCUMENT_ROOT Absolute path to the http document root
*/
if ( !defined('SYSTEM_DOCUMENT_ROOT') )
	define('SYSTEM_DOCUMENT_ROOT', SYSTEM_DIRECTORY_ROOT . "/htdocs" );

/**
* SYSTEM_TMPDIR
*
* The tmp directory where to store uploaded files and to execute scripts in.
* It must be writable by the webserver and not web-accessible
*
* @global constant SYSTEM_TMPDIR Tmp directory
*/
define('SYSTEM_TMPDIR', SYSTEM_DIRECTORY_ROOT . "/tmp" );

/**
* SYSTEM_ENGINE_ROOT
*
* Dynamically figure out where in the filesystem the engine is located.
*
* @global constant SYSTEM_ENGINE_ROOT Absolute path to our framework
*/
define('SYSTEM_ENGINE_ROOT', SYSTEM_DIRECTORY_ROOT );

/**
* SYSTEM_DATA_ROOT
*
* Path to the data directory eg where modENCODE BED files are stored
*
* @global constant SYSTEM_DATA_ROOT
**/
define ('SYSTEM_DATA_ROOT', SYSTEM_DIRECTORY_ROOT.'/data');

/**
* SYSTEM_ERRORDOCS_PATH
*
* Path to error docs - error docs named eg 404.php
*
* @global constant SYSTEM_ERRORDOCS_PATH
**/
define ('SYSTEM_ERRORDOCS_PATH', SYSTEM_DOCUMENT_ROOT.'/errordocs');


/**
* SYSTEM_LOG_FILE
*
* Path to centralized log file that can be accessed directly from our
* application classes.
*
* @global constant SYSTEM_LOG_FILE Path to log file
* @link http://pear.php.net/package/Log
*/
define('SYSTEM_LOG_FILE', SYSTEM_DATA_ROOT.'/logs/debug/log.txt');

/**
* SMARTY_DIR
*
* @global constant SMARTY_DIR Path to Smarty install
* @link http://smarty.php.net
*/
define('SMARTY_DIR', SYSTEM_DIRECTORY_ROOT.'/includes/Smarty-3.1.29/'); //version 3.1.29

/**
* CONF_DIR
*
* @global constant CONF_DIR Path to Config directory
*/
define('SYSTEM_CONFIG_DIR', dirname( __FILE__ ) );


/**
* SYSTEM_PRESENTER
*
* This defines the default view (presenter)
*
* This can be overridden with $_GET['presenter']
*
* @global constant SYSTEM_PRESENTER Default View presenter (smarty, rest, debug)
*/
define('SYSTEM_PRESENTER','smarty');

define('SYSTEM_TEMPLATE','default');

define('SYSTEM_DEBUG_OUTPUT', 'log');
/** include database config file **/

define('SECRET_KEY', '8MnQI6kwPzQj8aZN');

require_once('db.php');

?>
