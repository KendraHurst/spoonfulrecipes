<?php

namespace Helpers;

class VerifyLogin
{
	public function checkLogin($mapper)
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$crypt = \Bcrypt::instance();
		$user_pw = $mapper->select('password', array('email = ? and access_level = \'admin\'', $username));

		if(!$user_pw) {
			$login_valid = false;
		} else {
			$login_valid = $crypt->verify($password, $user_pw[0]['password']);
		}
		return $login_valid;
	}
}

