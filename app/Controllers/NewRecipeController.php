<?php

namespace Controllers;

use View;
use Models\Users;

class NewRecipeController 
{
	public function new_recipe($f3)
	{
		if(isset($_SESSION['user'])) {
			$users = new Users();
			$author = $users->select('name', array('email = ?', $_SESSION['user']))[0]['name'];
			$view = View::instance();
			echo $view->render('new_recipe.php', null, compact('f3', 'view', 'author'));
		} else {
			header('Location: http://localhost:8000/login?from=new-recipe');
		}
	}
}
