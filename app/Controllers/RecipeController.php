<?php

namespace Controllers;

use View;
use Web;
use Models\Users;
use Models\Recipe;
use Models\Ingredients;
use Models\Directions;
use Models\Reviews;

class RecipeController 
{
	public function recipe_redirect($f3) {
		$recipe_mapper = new Recipe();

		$recipe_slug = $f3->get('PARAMS.recipe');

		if(is_numeric($recipe_slug)) {
			$recipes = $recipe_mapper->select('*', array('id = ? and active', $recipe_slug));
		} else {
			print($recipe_slug);
			$search = str_replace('-', '%', $recipe_slug);
			$recipes = $recipe_mapper->select('*', array('name LIKE ? and active ORDER BY publish_date DESC', $search));
		}

		if (!$recipes) {
			$f3->error(404);
		} else {
			$recipe = $recipes[0];
			header('Location: ' . $f3->get('siteurl') . '/recipes/' . $recipe['id'] . '/' . Web::instance()->slug($recipe['name']));
			die();
		}
	}

    public function recipe($f3) {
		$recipe_mapper = new Recipe();

		$recipe_id = $f3->get('PARAMS.id');
		$recipe_slug = $f3->get('PARAMS.recipe');

		$recipes = $recipe_mapper->select('*', array('id = ? and active', $recipe_id));
		if (!$recipes) {
			$f3->error(404);
		} else {
			$recipe = $recipes[0];

			if($recipe_slug !== Web::instance()->slug($recipe['name'])) {

				header('Location: ' . $f3->get('siteurl') . '/recipes/' . $recipe['id'] . '/' . Web::instance()->slug($recipe['name']));
				die();

			} else {
				$user_mapper = new Users();
				$ingredient_mapper = new Ingredients();
				$direction_mapper = new Directions();
				$review_mapper = new Reviews();

				$ingredients = $ingredient_mapper->select('*', array('recipe_id = ?', $recipe['id']));
				$directions = $direction_mapper->select('*', array('recipe_id = ?', $recipe['id']));
				$reviews = $review_mapper->select('*', array('recipe_id = ? and approved', $recipe['id']));
				$author = $user_mapper->select('name', array('id = ?', $recipe['author']))[0]['name'];

				$view = View::instance();
				echo $view->render('recipe.php', null, compact('f3', 'view', 'recipe_slug', 'recipe', 'ingredients', 'directions', 'reviews', 'author'));
			}
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

