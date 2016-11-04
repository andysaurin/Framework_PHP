<?php

/**
* NQ_User
*
* @package Framework
* @filesource
*/

/**
* NQ_User
*
* Base user object.
*
* @package Framework
*/
class NQ_User extends NQ_Object_DB
{
	public $id;
	public $username;
	public $status;
//	public $password;
	public $lastLogin;
	public $dateUpdated;
	public $is_admin;
	public $locked;
	public $request_uri;
	public $request_host;
	public $type;
//	public $module_permissions;
	public $message;
	

/*
	public $module_permission_level;
	public $module_section_permissions;
	public $module_section_permission_level;
*/
//	public $iplock;
	public $message_stats;

	public function __construct($id=null)
	{
		parent::__construct();

		if ($id === null) {
			if ( !is_object($session) )
				$session = NQ_Session::singleton();

			if (!is_numeric($session->id)) {
				$id = 0;
			} else {
				$id = $session->id;
				$username = $session->username;
				$password = $session->password;
			}
		}

		if ($id > 0) {

			$sql = "SELECT *
					FROM users u
					WHERE u.email = '".$username."' AND u.password = '".$password."' LIMIT 1";

			$user = $this->db->get_row($sql);
			if ($user->id < 1) {
				$this->logout_user();
			}

		}

		if( !is_object( $user ) )
    		$user = new StdClass;
		if( !is_object( $user->message ) )
    		$user->message = new StdClass;
		if ( !isset($user->message->text) )
			$user->message->text = false;
		if ( !isset($user->message->type) )
			$user->message->type = false;
		if ( !isset($user->message->delay) )
			$user->message->delay = false;

		if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ) {
			$protocol = 'https';
		}else{
			$protocol = 'http';
		}
		
		$host = $_SERVER['SERVER_NAME']; //but see http://stackoverflow.com/questions/2297403/http-host-vs-server-name
		$user->request_host = "{$protocol}://{$host}";
		$user->request_uri = $_SERVER['REQUEST_URI'];

		if ( isset($user->id) && is_numeric($user->id) && $user->id > 0 ) {

			//check to make sure the session hasn't been hijacked - if so, log out everyone
			if ( isset($session->ip) && $session->ip != $_SERVER['REMOTE_ADDR'] ) {
				if ( !$_SERVER['HTTP_X_FORWARDED_FOR']
					&& !$_SERVER['HTTP_X_FORWARDED']
					&& !$_SERVER['HTTP_FORWARDED_FOR']
					&& !$_SERVER['HTTP_CLIENT_IP']
                    && !$_SERVER['HTTP_VIA']
                    && !$_SERVER['HTTP_X_WISP']
				) { //user is not on a proxy
					$user->locked = 'Session IP / User IP mismatch. You have been logged out for security reasons.';
				}

			}

			if ( $user->locked ) { //the user has been locked out, so log them out

				$this->logout_user();

				//now set the message
				$display_message['text'] = $user->locked;
				$display_message['type'] = 'alert';
				$display_message['delay'] = '8000';
				session_start();
				$_SESSION['message'] = $display_message;

				header("Location: /login/?ret=".NQ_Module::nq_encrypt(SECRET_KEY, $_SERVER['REQUEST_URI'], true));
				exit();

			} else {

				if ( !isset($_GET['class']) )
					$_GET['class'] = 'index'; // for module index pages, _GET[index] isn't set, so we need to specify it here to force permission checking


				// create a unique xsrf key
				$user->xsrf_key = NQ_Module::xsrf_create($user->username, $user->password);


				//initiate the session class if not initiated
				if( !is_object( $this->session ) ) {
    				$this->session = new StdClass;
				}

				foreach ($user as $key=>$val) { //session vars
					$this->session->$key = $val;
				}

				$this->setFrom($user); //individual $this->user vars

//				$this->db->query("UPDATE users SET lastSeen=NOW() WHERE id='".$user->id."' LIMIT 1");


			}
		}

		//initiate the session class if not initiated
		if( !is_object( $this->session ) ) {
			$this->session = new StdClass;
		}

//print_r($user);
	}


	public function logout_user()
	{

		NQ_Session::destroy();
		unset($_SERVER['PHP_AUTH_USER']);
		if ( is_array($_SESSION) )
			unset($_SESSION);

		if (is_array($_COOKIE)) {
			foreach ($_COOKIE as $key => $val) {
       			NQ_Cookie::delete($key);
			}
		}
		setcookie("user", '', time()-31536000, '/', $_SERVER['HTTP_HOST']);
		return;
	}



	public function __destruct()
	{
		parent::__destruct();
	}

}

?>
