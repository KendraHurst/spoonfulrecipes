<?php

namespace Models;

use Models\Recipe;
use Models\Users;
use Models\Ingredients;
use Models\Directions;

class AddRecipe 
{
	public function addRecipe($f3)
	{
		$recipe_id = $this->insertRecipe();
		$this->addIngredients($recipe_id);
		$this->addDirections($recipe_id);
	}

	private function insertRecipe()
	{
		$recipe = new Recipe();

		$users = new Users();
		$author = $users->select('id', array('email = ?', $_SESSION['user']))[0]['id'];

		$recipe->name = $_POST['name'];
		$recipe->author = $author;
		$recipe->title = $_POST['title'];
		$recipe->description = $_POST['description'];
		$recipe->prep_time = $_POST['prep'];
		$recipe->cook_time = $_POST['cook'];
		$recipe->calories = $_POST['calories'] ?: null;
		$recipe->yield = $_POST['yield'];
		$recipe->publish_date = $_POST['publish'];
		$recipe->category = $_POST['category'] ? implode(', ', $_POST['category']) : null;
		$recipe->cuisine = trim($_POST['cuisine']) ?: null;
		$recipe->keywords = trim($_POST['keywords']) ?: null;
		$recipe->content = trim($_POST['content']);

		if (isset($_POST['active'])) {
			$recipe->active = 1;
		} else {
			$recipe->active = 0;
		}

		$recipe->insert();
		$recipe_id = $recipe->get('_id');
		
		return $recipe_id;
	}

	private function addIngredients($recipe_id)
	{
		$ingredient = new Ingredients();

		$ingredients = $_POST['ingredients-ingredients'];
		$measures = $_POST['ingredients-measures'];
		$optional = $_POST['ingredients-optional'];
		$notes = $_POST['ingredients-notes'];

		for($i = 0; $i < count($ingredients); $i++) {
			$ingredient->recipe_id = $recipe_id;
			$ingredient->measure = $measures[$i];
			$ingredient->ingredient = $ingredients[$i];

			if ($optional[$i] === "true") {
				$ingredient->optional = 1;
			} else {
				$ingredient->optional = 0;
			}

			$ingredient->note = $notes[$i] ?: null;
			$ingredient->display_order = $i;

			$ingredient->insert();
			$ingredient->reset();
		}
	}

	private function addDirections($recipe_id)
	{
		$direction = new Directions();

		$names = $_POST['directions-name'];
		$texts = $_POST['directions-text'];
		$notes = $_POST['directions-notes'];
		$images = $_POST['directions-image'];

		for($i = 0; $i < count($names); $i++) {
			$direction->recipe_id = $recipe_id;
			$direction->name = $names[$i];
			$direction->text = $texts[$i];
			$direction->image = $images[$i] ?: null;
			$direction->note = trim($notes[$i]) ?: null;
			$direction->display_order = $i;

			$direction->insert();
			$direction->reset();
		}
	}

	private function addImages($recipe_id)
	{
		//Put stuff here once you set up S3
	}
}
