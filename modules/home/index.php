<?php

class index extends NQ_Auth_No
{
	public function __construct()
	{
		parent::__construct();
		$this->class_title = "My New Site";
		
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