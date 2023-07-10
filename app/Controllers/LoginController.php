<?php

namespace Controllers;

use View;
use Models\Users;
use Helpers\VerifyLogin;

class LoginController 
{
    public function login($f3) {

		$user_mapper = new Users();
		$view = View::instance();

		if(isset($_SESSION['user'])) {
			$name = $user_mapper->select('name', array('email = ?', $_SESSION['user']))[0]['name'];
			echo $view->render('login.php', null, compact('f3', 'view', 'name'));
		} elseif(isset($_POST['username'])) {
			$login_checker =  new VerifyLogin();
			$login_valid = $login_checker->checkLogin($user_mapper);
			if($login_valid) {
				$_SESSION['user'] = $_POST['username'];
				$from = $_POST['from'];
				header("Location: " . $f3->get('siteurl') . "/" . $from);
				die();
			} else {
				echo $view->render('login.php', null, compact('f3', 'view', 'login_valid'));
			}
		} else {
			echo $view->render('login.php', null, compact('f3', 'view'));
		}
    }
	public function loginform($f3) {
		$view = View::instance();
		echo $view->render('login.php', null, compact('f3', 'view'));
	}
	public function logout($f3) {
		unset($_SESSION['user']);
		header("Location: " . $f3->get('siteurl'));
	}
}
