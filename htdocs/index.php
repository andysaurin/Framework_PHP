<?php
/**
* index.php
*
* @package Framework
*/
//ob_start();

//ini_set('error_reporting', 6135);
//ini_set("display_errors", true);

//if for the agony we want to be strict perfect, uncomment these lines to see the errors
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
//set_error_handler("exception_error_handler");

if ( !defined('SYSTEM_DOCUMENT_ROOT') )
	define('SYSTEM_DOCUMENT_ROOT', dirname(__FILE__) );

require_once( SYSTEM_DOCUMENT_ROOT . '/../config/config.php');

set_include_path( SYSTEM_DIRECTORY_ROOT . '/includes' . ':' .SYSTEM_DIRECTORY_ROOT . '/modules'.':'. get_include_path() );

function autoloader($class)
{
	if (preg_match('/^NQ_/', $class)) {
		$file = str_replace('_','/',substr($class,3)).'.php';
		require_once(SYSTEM_DIRECTORY_ROOT.'/includes/'.$file);
	}elseif (preg_match('/^Smarty_/', $class)) {
		if(!defined(SMARTY_SPL_AUTOLOAD))
			define('SMARTY_SPL_AUTOLOAD', 1);
		set_include_path(get_include_path() . PATH_SEPARATOR . SMARTY_SYSPLUGINS_DIR);
		require_once(strtolower($class).".php");
	}elseif (preg_match('/^MO_/', $class)) {
		$file = str_replace('_','/',substr($class,3)).'.php';
		require_once(SYSTEM_DIRECTORY_ROOT.'/modules/'.$file);
	}else{
		$file = str_replace('_','/',$class).'.php';
		require_once($file);
	}
}
require dirname(__FILE__) . '/vendor/autoload.php';
spl_autoload_register('autoloader');


//kick off the whole shebang
NQ_Server::instantiate();


?>
