<?php

class index extends NQ_Auth_Admin
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "Admin Panel";
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