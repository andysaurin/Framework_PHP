<?php

class index extends NQ_Auth_User
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "Your account";
	}

	public function __default()
	{

	}
	
	public function __destruct()
	{
		parent::__destruct();
	}
	
}
	
?>