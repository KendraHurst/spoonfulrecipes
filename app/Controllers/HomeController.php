<?php

namespace Controllers;

use View;
use Models\Recipe;
use Models\Reviews;

class HomeController 
{
    public function index($f3) {
		$recipe_mapper = new Recipe();
		$review_mapper = new Reviews();
		$reviews = [];
		$view = View::instance();

		$recipes = $recipe_mapper->select('id, name, description', array('active ORDER BY publish_date DESC LIMIT 4'));
		foreach ($recipes as $recipe) {
			foreach($review_mapper->select('rating, recipe_id', array('recipe_id = ? and approved', $recipe['id'])) as $review) {
				$reviews[] = $review;
			}
		}

		echo $view->render('home.php', null, compact('f3', 'view', 'recipes', 'reviews'));
    }
}
