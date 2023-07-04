<?php

namespace Controllers;

use View;
use Models\Users;
use Models\Recipe;
use Models\Ingredients;
use Models\Directions;
use Models\UpdateRecipe;

class UpdateRecipeController 
{
	public function edit_recipe($f3)
	{
		if(isset($_SESSION['user'])) {
			$view = View::instance();
			$recipes = new Recipe();
			$users = new Users();
			$author = $users->select('id, name', array('email = ?', $_SESSION['user']))[0];

			if(isset($_GET['edit-recipe'])) {
				$recipe_id = intval($_GET['edit-recipe']);
				$recipe = $recipes->select('*', array('id = ? and author = ?', $recipe_id, $author['id']))[0];

				if($recipe) {
					$ingredient_mapper = new Ingredients();
					$direction_mapper = new Directions();

					$ingredients = $ingredient_mapper->select('*', array('recipe_id = ? ORDER BY display_order', $recipe['id']));
					$directions = $direction_mapper->select('*', array('recipe_id = ? ORDER BY display_order', $recipe['id']));

					echo $view->render('edit_recipe.php', null, compact('f3', 'view', 'recipe', 'ingredients', 'directions', 'author'));
				} else {
					header('Location: http://localhost:8000/');
				}
			} else {
				$recipe_list = $recipes->select('id, name', array('author = ?', $author['id']));
				echo $view->render('select_recipe.php', null, compact('f3', 'view', 'recipe_list'));
			}
		} else {
			header('Location: http://localhost:8000/login?from=edit-recipe');
		}
	}

	public function update_recipe($f3)
	{
		if(isset($_SESSION['user'])) {
			$update = new UpdateRecipe();
			$update->editRecipe($f3);
			header('Location: http://localhost:8000/');
		} else {
			header('Location: http://localhost:8000/login?from=edit-recipe');
		}
	}
}

