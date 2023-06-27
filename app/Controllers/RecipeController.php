<?php

namespace Controllers;

use View;
use Models\Recipe;
use Models\Ingredients;
use Models\Directions;

class RecipeController 
{
    public function recipe($f3) {
		$recipe_mapper = new Recipe();
		$ingredient_mapper = new Ingredients();
		$direction_mapper = new Directions();
		$recipe_slug = $f3->get('PARAMS.recipe');
		$search = str_replace('-', '%', $recipe_slug);

		$recipes = $recipe_mapper->select('*', array('name LIKE ? and active', $search));
		if (!$recipes) {
			$f3->error(404);
		} else {
			$recipe = $recipes[0];
			$ingredients = $ingredient_mapper->select('*', array('recipe_id = ?', $recipe['id']));
			$directions = $direction_mapper->select('*', array('recipe_id = ?', $recipe['id']));
			$view = View::instance();
			echo $view->render('recipe.php', null, compact('f3', 'view', 'recipe_slug', 'recipe', 'ingredients', 'directions'));
		}
    }
    public function recipes($f3) {
		$recipe_mapper = new Recipe();

		$recipes = $recipe_mapper->select('name, description', array('active ORDER BY publish_date DESC'));
		$view = View::instance();
		echo $view->render('recipes.php', null, compact('f3', 'view', 'recipes'));
    }
}

