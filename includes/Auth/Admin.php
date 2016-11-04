<?php

/**
* NQ_Auth_Admin
*
* @package Framework
* @filesource
*/

/**
* NQ_Auth_Admin
*
* If the module class requires that a user be an admin, then extend it from this Auth class. 
*
* @package Framework
*/
abstract class NQ_Auth_Admin extends NQ_Auth
{
	function __construct()
	{
		parent::__construct();
	}

	function authenticate()
	{
		$this->set('auth','admin');
		return ($this->session->is_admin == 1);
	}

	function __destruct()
	{
		parent::__destruct();
	}
}

?>
