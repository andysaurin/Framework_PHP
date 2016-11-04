<?php

/**
* update
*
* @license http://www.opensource.org/licenses/gpl-license.php
* @package Modules
* @filesource
*/

//require_once('Validate.php');

/**
* update
*
*
* @package Modules
*/
class update extends NQ_Auth_User
{
	public function __construct()
	{

		parent::__construct();


	}

	public function __default()
	{

		$process = null;
		$errors = array();

		if ( isset($_POST['account_form']) && count($_POST) > 0 ) {

			$this->update_account();

		}

	}


	public function update_account()
	{

		$update_user_table = false;
		$new_name = $this->session->name;
		$new_username = $this->session->username;
		$new_pass = $this->session->password;

		if ( !$this->xsrf_validate($_POST['xsrf_key'], $this->session->username, $this->session->password) ) {

			$message['text'] = "The form expired or could not be validated.<br />Please submit the form again.";
			$message['type'] = 'alert';

			$update_user_table = false;

		} else {


			if ( isset($_POST['name']) && $_POST['name'] != '' && $_POST['name'] != $this->session->name ) {

				$new_name = mysql_real_escape_string( $_POST['name'] );
				$update_user_table = true;

			}

			if ( isset($_POST['email']) && $_POST['email'] != '' && $_POST['email'] != $this->session->username ) {
				//user is changing their email address

				if ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {

					$errors['email'] = "The provided email address is not valid.";
					$update_user_table = false;

				} else {

					if ( $this->unique_username(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) === true ) { //username is unique

						$update_user_table = true;
						$new_username = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

					} else {

						$errors['email'] = "The email address you provided is already in use.";
						$update_user_table = false;

					}
				}

			}


			if ( isset($_POST['current_password']) && $_POST['current_password'] != '' ) {

				if ( md5($_POST['current_password']) != $this->session->password ) {

					$errors['current_password'] = "Your current password is incorrect.";

				} else {

					if ( $_POST['new_password_1'] != '' || $_POST['new_password_2'] != '' ) {

						if ( $_POST['new_password_1'] != $_POST['new_password_2'] ) {

							$errors['new_password'] = "The new passwords you entered did not match.";
							$update_user_table = false;

						} else {

							$new_pass = md5($_POST['new_password_1']);
							$update_user_table = true;

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
			} elseif ($update_user_table === true) {

				$sql = "UPDATE `users` SET `name`='{$new_name}', `password`='{$new_pass}', `email`='{$new_username}', `username`='{$new_username}' WHERE `id`={$this->session->id} LIMIT 1";

				if ( !$this->db->query($sql) ) {

					$errors[] = "We cannot process your request at this time. (Error code 591).";

				} else {
					if ($this->db->rows_affected > 0) {

						$message['text'] = "Your account details have been updated.";
						$message['type'] = 'success';
						$message['delay'] = 3000;
						$this->session->message = $message;

						$this->session->name = $new_name;
						$this->session->username = $new_username;
						$this->session->password = $new_pass;
						$this->session->email = $new_username;

						header("Location: /{$this->moduleName}/{$this->className}");
						exit();

					}

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
