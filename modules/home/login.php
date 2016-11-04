<?php

/**
* login
*
*
*
* @license http://www.opensource.org/licenses/gpl-license.php
* @package Modules
* @filesource
*/

//require_once('Validate.php');

/**
* login
*
*
* @package Modules
*/
class login extends NQ_Auth_No
{
	public function __construct()
	{
		parent::__construct();
	}

	public function __default()
	{

		
		if ( $this->user->id > 0 ) {
			// a logged-in user tried to load a page for which they didn't have permission
			// log them out
			header("Location: /logout");
			exit;
		}
		if ($_POST['username'] && $_POST['password']) {

			if ( filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ) {
				$username = $_POST['username'];
			}
			if ( $_POST['password'] ) {
				$password = md5($_POST['password']);
			}

			if ( isset($username) && isset($password) ) {

				//turn off mysql disk caching if it's on for all the function
				if (DB_USECACHE == true) {
					$this->db->cache_queries = false;
					$this->db->use_disk_cache = false;
				}


				$sql = "SELECT *
						FROM users u
						WHERE u.email = '".$username."' AND u.password = '".$password."' LIMIT 1";

				$user = $this->db->get_row($sql);

				if( $user->status == 'Suspended' ) {

					$message['text'] = "This account has been suspended.<br>";
					$message['type'] = 'alert';
					unset($user);

				}elseif ( is_numeric($user->id) && $user->id > 0 ) {

					if ( !is_object($session) )
						$session = NQ_Session::singleton();

					//store when they had previously last logged in.
					$session->prev_login_time = $user->last_login;
					$session->prev_login_ip = $user->last_login_ip;

					//store their current session IP to prevent session hijacking;
					$session->ip = $_SERVER['REMOTE_ADDR'];

					//now update the time they logged in.
					$this->db->query("UPDATE `users SET last_login='".time()."' WHERE id='".$user->id."' LIMIT 1");

					foreach ($user as $key=>$val) { //session vars
						$session->$key = $val;
					}

					//turn disk caching back on if default is to cache
					if (DB_USECACHE == true) {
						$this->db->cache_queries = true;
						$this->db->use_disk_cache = true;
					}
					


					$message['text'] = "Welcome {$user->name}<br />You are logged in as <i>".$_POST['username'].'</i>';
					$message['type'] = 'success';
					$message['delay'] = '4000';

					if ( isset($_GET['ret']) ) {
						$go = NQ_Module::nq_decrypt(SECRET_KEY, $_GET['ret'], true);
					}else {
						$go = "/home/";
					}

					$session->message = $message;
					$session->complete_signup = 1;


					header("Location: $go");
					exit();

				} else { //invalid user/pass

					$message['text'] = 'Invalid username and/or password.';
					$message['type'] = 'alert';
					$message['delay'] = '4000';

				}

				//turn disk caching back on if default is to cache
				if (DB_USECACHE == true) {
					$this->db->cache_queries = true;
					$this->db->use_disk_cache = true;
				}

			} else {

				$message['text'] = "Invalid username and/or password.";
				$message['type'] = 'alert';
				$message['delay'] = '4000';

			}

		}elseif ( $_POST && ( !$_POST['username'] || !$_POST['password'] )) {
			$message['text'] = 'You must provide a login and password.';
			$message['type'] = 'warning';
			$message['delay'] = '4000';
		}
		if (is_array($message)) {
			$this->session->message = $message;
		}
	}

	public function __destruct()
	{
		parent::__destruct();
	}
}


?>
