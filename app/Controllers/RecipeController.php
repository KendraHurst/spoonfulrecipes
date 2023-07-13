<?php

namespace Controllers;

use View;
use Models\Recipe;
use Models\Ingredients;
use Models\Directions;
use Models\Reviews;

class RecipeController 
{
    public function recipe($f3) {
		$recipe_mapper = new Recipe();
		$ingredient_mapper = new Ingredients();
		$direction_mapper = new Directions();
		$review_mapper = new Reviews();

		$recipe_slug = $f3->get('PARAMS.recipe');
		$search = str_replace('-', '%', $recipe_slug);

		$recipes = $recipe_mapper->select('*', array('name LIKE ? and active', $search));
		if (!$recipes) {
			$f3->error(404);
		} else {
			$recipe = $recipes[0];

			$view = View::instance();
			echo $view->render('recipe.php', null, compact('f3', 'view', 'recipe_slug', 'recipe', 'ingredients', 'directions', 'reviews'));
		}
    }
    public function recipes($f3) {
		$recipe_mapper = new Recipe();
		$review_mapper = new Reviews();

		$recipes = $recipe_mapper->select('id, name, description', array('active ORDER BY publish_date DESC'));
		$reviews = $review_mapper->select('recipe_id, rating', 'approved');
		$view = View::instance();
		echo $view->render('recipes.php', null, compact('f3', 'view', 'recipes', 'reviews'));
    }
}

