<?php

namespace Controllers;

use View;
use Models\Recipe;

class RecipeController 
{
    public function recipe($f3) {
		$recipe_mapper = new Recipe();
		$recipe_slug = $f3->get('PARAMS.recipe');
		$search = str_replace('-', '%', $recipe_slug);

		$recipes = $recipe_mapper->select('*', array('name LIKE ? and active ORDER BY publish_date', $search));
		if (!$recipes) {
			$f3->error(404);
		} else {
			$recipe = $recipes[0];
			$view = View::instance();
			echo $view->render('recipe.php', null, compact('f3', 'view', 'recipe_slug', 'recipe'));
		}
    }
    public function recipes($f3) {
		$recipe_mapper = new Recipe();

		$recipes = $recipe_mapper->select('*', array('active'));
		$view = View::instance();
		echo $view->render('recipes.php', null, compact('f3', 'view', 'recipes'));
    }
}

