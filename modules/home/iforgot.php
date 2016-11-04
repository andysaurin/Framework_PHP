<?php

/**
* iforgot
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
class iforgot extends NQ_Auth_No
{
	public function __construct()
	{
		parent::__construct();

		$this->set('recaptcha_key', RECAPTCHA_PUBLIC_KEY);
		$this->set('show_recaptcha', true);

		if ( $this->user->id > 0 ) {
			header("Location: /home/");
			exit;
		}

	}

	public function __default()
	{

		$process = null;

		if ( isset($_POST['email']) && !$_POST['g-recaptcha-response']) {

			$message['text'] = "You must verify you are not a robot.";
			$message['type'] = 'alert';
			$message['delay'] = 4000;
			$location = "/home/iforgot";

		} elseif ( isset($_POST['email']) && isset($_POST['g-recaptcha-response'])) {

			if ( $this->verify_captcha($_POST['g-recaptcha-response']) != true ) {

				$message['text'] = "Anti-robot verification failed.<br />Please try again.";
				$message['type'] = 'alert';
				$message['delay'] = 4000;
				$location = "/home/iforgot";

			}elseif ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {

				$message['text'] = "Not a valid email address.";
				$message['type'] = 'alert';
				$location = "/home/iforgot";

			} else {

				$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

				$user = $this->db->get_row( "SELECT `id`, `name` FROM `users` WHERE `email` LIKE '{$email}' LIMIT 1" );

				if ( $user->id > 0 )
					$process = true;

				else {

					$message['text'] = "{$email} is not a registered email address.";
					$message['type'] = 'alert';
					$location = "/home/iforgot";

				}

			}

			if ( $process === true ) {

				$tmp_pass = md5( $this->uuid() );
				$expires = time() + (60*60);

				$template = file_get_contents( SYSTEM_DIRECTORY_ROOT . "/templates/email/reset_pass_request.txt" );

				if ( !strpos($template, "##NAME##") ) {

					$message['text'] = "We cannot process your request at this time<br />(Error code 531).";
					$message['type'] = 'alert';

				} else {

					$email_body = str_ireplace("##NAME##", $user->name, $template);
					$email_body = str_ireplace("##TMP_PASS##", $tmp_pass, $email_body);
					$email_body = str_ireplace("##URI##", SERVER_URI, $email_body);

					if ( !$this->db->query("UPDATE `users` SET `tmp_password`='{$tmp_pass}', `tmp_password_expires`={$expires} WHERE `id`={$user->id} LIMIT 1") ) {

						$message['text'] = "We cannot process your request at this time<br />(Error code 650).";
						$message['type'] = 'alert';

					} else {

						$this->mail = new StdClass;
						$this->mail->to_email_address = $email;
						$this->mail->subject = "We have received a request to reset your password.";
						$this->mail->body = $email_body;
						$this->mail->body_html = nl2br($email_body);

						if ( $this->send_mail() == false ) {

							$message['text'] = "We were unable to send an email to {$email}<br />(Error code 390).";
							$message['type'] = 'alert';

						} else {

							$message['text'] = "An email has been sent to {$email} explaining how to reset your password.<br>If you cannot find this email, please verify it hasn't found its way into your Spam box";
							$message['type'] = 'success';

						}

					}

				}

			}

			if (is_array($message)) {
				$this->session->message = $message;
			}

			header("Location: /{$location}");
			exit();


		}
		if (is_array($message)) {
			$this->session->message = $message;
		}


	}

	public function reset()
	{

		$md5 = $_GET['who'];

		if ( !preg_match("/^[a-zA-Z0-9]{32}$/", $md5) ) {
			$message['text'] = "Invalid user. We are unable to reset your password.<br />";
			$message['type'] = 'alert';
			$this->session->message = $message;
			header("Location: /");
			exit();
		}

		$result = $this->db->get_row("SELECT * FROM `users` WHERE `tmp_password` LIKE '{$md5}' LIMIT 1");
//echo "<p>SELECT * FROM `users` WHERE `tmp_password` == '{$md5}' LIMIT 1</p>";

		if ( !$result ) {

			$message['text'] = "Invalid security key request.<br />";
			$message['type'] = 'alert';
			$this->session->message = $message;

			return;

		}

		if ( $result->tmp_password_expires < time() ) {

			$message['text'] = "The request to reset your password has expired.<br>Please submit a new request.";
			$message['type'] = 'alert';
			$this->session->message = $message;

			$this->db->query("UPDATE `users` SET `tmp_password`=NULL, `tmp_password_expires`=NULL WHERE `id`={$result->id} LIMIT 1");

			return;

		}

		if ( $result->tmp_password_expires > time() ) {

			$this->set('who', $md5);
			$this->set('email', md5($result->email) );

			if ( isset($_POST['password']) ) {


				if ( !preg_match("/^.{6,}$/", $_POST['password']) ) {
					$message['text'] = "Passwords must be at least 6 characters long.<br>Please try again.";
					$message['type'] = 'alert';
					$this->session->message = $message;

					return;
				}


				if ( $_POST['password'] != $_POST['password2'] ) {

					$message['text'] = "The two password entries do not match.<br>Please try again.";
					$message['type'] = 'alert';
					$this->session->message = $message;

					return;
				}

				//all good - rest the password and remove the tmp_password
				$user_id = $result->id;
				$pass = md5($_POST['password']);
				$this->db->query("UPDATE `users` SET `password`='{$pass}', `tmp_password`=NULL, `tmp_password_expires`=NULL WHERE `id`={$user_id} LIMIT 1");

				if ( $this->db->rows_affected == 1 ) {

					$message['text'] = 'Your password has been successfully reset.';
					$message['type'] = 'success';
					$message['delay'] = '4000';
					$this->session->message = $message;
					header("Location: /login/?username={$result->email}");
					exit();

				} else {

					$message['text'] = "An error occurred resetting your password.";
					$message['type'] = 'alert';
					$this->session->message = $message;

					return;
				}



			}

		}


	}

	public function __destruct()
	{
		parent::__destruct();
	}
}


?>
