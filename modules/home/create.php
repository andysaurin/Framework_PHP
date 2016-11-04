<?php

/**
* create
*
* @license http://www.opensource.org/licenses/gpl-license.php
* @package Modules
* @filesource
*/

//require_once('Validate.php');

/**
* create
*
*
* @package Modules
*/
class create extends NQ_Auth_No
{
	public function __construct()
	{
		parent::__construct();

		$this->set('recaptcha_key', RECAPTCHA_PUBLIC_KEY);
		$this->set('show_recaptcha', true);
	}

	public function __default()
	{

		$process = null;
		$errors = array();

		if ( isset($this->user->id) && $this->user->id > 0 ) {
			header("Location: /");
			exit;
		}

		if ( isset($_POST) && count($_POST) > 0 ) {

			if ( !preg_match("/^.{4,}$/", $_POST['name']) ) {
				$errors['name'] = "Please supply your name";
			}
			if ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				$errors['email'] = "Please supply a valid email address";
			}
			if ( !preg_match("/^.{6,}$/", $_POST['password']) ) {
				$errors['password'] = "Passwords must be at least 6 characters long.";
			}

			if ( !$_POST['g-recaptcha-response']) {

				$errors['g-recaptcha-response'] = "You must verify you are not a robot.";

			}
			if ( count($errors) < 1 ) {

				if ( $this->verify_captcha($_POST['g-recaptcha-response']) != true ) {

					$message['text'] = "Anti-robot verification failed.<br />Please try again.";
					$message['type'] = 'alert';
					$message['delay'] = 4000;

				}elseif ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {

					$message['text'] = "Not a valid email address.";
					$message['type'] = 'alert';

				}elseif ( $_POST['email'] != $_POST['email_repeat'] ) {

					$message['text'] = "The two email addresses do not match.";
					$message['type'] = 'alert';

				}elseif ( !preg_match("/^.{6,}$/", $_POST['password']) ) {

					$message['text'] = "Passwords must be at least 6 characters long.";
					$message['type'] = 'alert';

				} else {

					$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

					$user = $this->db->get_row( "SELECT `id` FROM `users` WHERE `email` LIKE '{$email}' LIMIT 1" );

					if ( $user->id > 0 ) {
						if ($_GET['ret'])
							$ret="?ret=".$_GET['ret'];
						$message['text'] = "{$email} is already registered.<p><a href='/home/iforgot/{$ret}'>Forgot Password?</a>";
						$message['type'] = 'alert';

					} else {

						$process = true;
					}

				}

				if ( $process === true ) {

					$now = time();
					$name = $_POST['name'];
					$email = $_POST['email'];
					$pass = md5( $_POST['password'] );
					$md5 = md5( $this->uuid() );

					$template = file_get_contents( SYSTEM_DIRECTORY_ROOT . "/templates/email/signup_verify_email.txt" );

					if ( !strpos($template, "##NAME##") || !strpos($template, "##KEY##") ) {

						$message['text'] = "We cannot process your request at this time<br />(Error code 531 - No email template).";
						$message['type'] = 'alert';

					} else {

						$email_body = str_ireplace("##NAME##", $name, $template);
						$email_body = str_ireplace("##KEY##", $md5, $email_body);
						$email_body = str_ireplace("##URI##", SERVER_URI, $email_body);

						//create the new user
						$this->db->query("
							INSERT INTO `users`
								(`name`, `username`, `password`, `email`, `dateRegistered`, `dateUpdated`)
							VALUES
								('{$name}', '{$email}', '{$pass}', '{$email}', NOW(), NOW())");
						$uid = $this->db->insert_id;

						if ( $uid < 1 ) {

							$message['text'] = "We cannot process your request at this time<br />(Error code 541).";
							$message['type'] = 'alert';

						} else {

							$this->db->query("UPDATE `users` SET `client_id`={$client_id} WHERE `id`={$uid} LIMIT 1");

							$message['text'] = "Your account has been created.<br />Login: {$email}";
							$message['type'] = 'success';

							//log the person in
							$sql = "SELECT *
									FROM users u
									WHERE u.email = '".$username."' AND u.password = '".$password."' LIMIT 1";

							$user = $this->db->get_row($sql);

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

							$session->message = $message;
							$session->complete_signup = 1;

							$this->session->message = $message;

							header("Location: /");
							exit;

						}

					}

				}

			}

			if ( count($errors) > 0 ) {
				$message['text'] .= "<ul>";
				foreach($errors as $error) {
					$message['text'] .= "<li>$error</li>\n";
				}
				$message['text'] .= "</ul>";
				$message['type'] = 'alert';
				$this->set('input_errors', $errors);
			}

			if (is_array($message)) {
				$this->session->message = $message;
			}

		}

	}


	public function __destruct()
	{
		parent::__destruct();
	}
}


?>
