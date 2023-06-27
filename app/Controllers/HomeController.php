<?php

namespace Controllers;

use View;
use Models\Recipe;

class HomeController 
{
    public function index($f3) {
		$recipe_mapper = new Recipe();
		$view = View::instance();

		$recipes = $recipe_mapper->select('name, description', array('active ORDER BY publish_date DESC LIMIT 4'));
		echo $view->render('home.php', null, compact('f3', 'view', 'recipes'));
    }
}
