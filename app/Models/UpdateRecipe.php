<?php

namespace Models;

use Models\Recipe;
use Models\Ingredients;
use Models\Directions;
use Helpers\ImageHelper;

class UpdateRecipe 
{
	public function editRecipe($f3)
	{
		$recipe_id = $_POST['recipe_id'];

		$this->updateRecipe($recipe_id);
		$this->updateIngredients($recipe_id);
		$this->updateDirections($recipe_id);
		$this->updateImages($recipe_id);
	}

	private function updateRecipe($recipe_id)
	{
		$recipe = new Recipe();
		$recipe->load(array('id = ?', $recipe_id));

		$recipe->name = $_POST['name'];
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

		$recipe->update();
		$recipe->reset();
	}

	private function updateIngredients($recipe_id)
	{
		$ingredient = new Ingredients();

		$current_ingredients = $ingredient->select('id', array('recipe_id = ?', $recipe_id));

		$ids = $_POST['ingredients-ids'];
		$ingredients = $_POST['ingredients-ingredients'];
		$measures = $_POST['ingredients-measures'];
		$optional = $_POST['ingredients-optional'];
		$notes = $_POST['ingredients-notes'];

		foreach ($current_ingredients as $current) {
			if(!in_array($current['id'], $ids)) {
				$ingredient->load(array('id = ?', $current['id']));
				$ingredient->erase();
				$ingredient->reset();
			}
		}

		for($i = 0; $i < count($ingredients); $i++) {
			if($ids[$i]) {
				$ingredient->load(array('id = ?', $ids[$i]));
			} else {
				$ingredient->recipe_id = $recipe_id;
			}

			$ingredient->measure = $measures[$i];
			$ingredient->ingredient = $ingredients[$i];

			if ($optional[$i] === "true") {
				$ingredient->optional = 1;
			} else {
				$ingredient->optional = 0;
			}

			$ingredient->note = $notes[$i] ?: null;
			$ingredient->display_order = $i;

			$ingredient->save();
			$ingredient->reset();
		}
	}

	private function updateDirections($recipe_id)
	{
		$direction = new Directions();

		$current_directions = $direction->select('id', array('recipe_id = ?', $recipe_id));

		$ids = $_POST['directions-id'];
		$names = $_POST['directions-name'];
		$texts = $_POST['directions-text'];
		$notes = $_POST['directions-notes'];
		$images = $_FILES['directions-image'];

		foreach ($current_directions as $current) {
			if(!in_array($current['id'], $ids)) {
				$direction->load(array('id = ?', $current['id']));
				$direction->erase();
				$direction->reset();
			}
		}

		for($i = 0; $i < count($names); $i++) {

			if($ids[$i]) {
				$direction->load(array('id = ?', $ids[$i]));
			} else {
				$direction->recipe_id = $recipe_id;
			}

			$direction->name = $names[$i];
			$direction->text = $texts[$i];
			$direction->image = $images['name'][$i] ?: null;
			$direction->note = trim($notes[$i]) ?: null;
			$direction->display_order = $i;

			$direction->save();
			$direction->reset();
		}
	}

	private function updateImages($recipe_id)
	{
		if($_FILES['main-image']['name']) {

			$size = filesize($_FILES['main-image']['tmp_name']);
			$image_type = exif_imagetype($_FILES['main-image']['tmp_name']);

			if ($size === false) {
				$uploadOk = 0;
			} else {
				$uploadOk = 1;
			}

			if ($_FILES["main-image"]["size"] > 2000000) {
				$uploadOk = 0;
			}

			if($image_type != 2 && $image_type != 3 && $image_type != 18 && $image_type != 1) {
				$uploadOk = 0;
			}

			if($uploadOk) {
				$main_img = $_FILES['main-image']['tmp_name'];
				$images = new ImageHelper;
				$results = $images->recipeMainImage($main_img, $recipe_id);

				return $results;
			}
		}
	}
}
