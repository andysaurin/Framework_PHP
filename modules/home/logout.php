<?php

/**
* logout
*
*
*
* @license http://www.opensource.org/licenses/gpl-license.php
* @package Modules
* @filesource
*/

/**
* logout
*
*
* @package Modules
*/
class logout extends NQ_Auth_No
{
	function __construct()
	{
		parent::__construct();
	}

	function __default()
	{
		$this->session->destroy();

		unset($_SERVER['PHP_AUTH_USER']);

		if (is_array($_COOKIE)) {
			foreach ($_COOKIE as $key => $val) {

               NQ_Cookie::delete($key);

			}
		}
		setcookie("user", '', time()-31536000, '/', $_SERVER['HTTP_HOST']);

		$session = NQ_Session::singleton();
		$message['text'] = 'You have been logged out.';
		$message['type'] = 'info';
		$message['delay'] = 4000;
		session_start();
		$_SESSION['message'] = $message;


		header("Location: /");
		exit();
	}

	function __destruct()
	{
		parent::__destruct();
	}
}

?>
