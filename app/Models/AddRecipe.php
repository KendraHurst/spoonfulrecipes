<?php

namespace Models;

use Models\Recipe;
use Models\Users;
use Models\Ingredients;
use Models\Directions;
use Helpers\ImageHelper;
use Web;

class AddRecipe 
{
	public function addRecipe($f3)
	{
		$recipe_id = $this->insertRecipe();
		$this->addIngredients($recipe_id);
		$this->addDirections($recipe_id);
		$this->addImages($recipe_id);
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
		$recipe->video = $_POST['video'] ?: null;

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
		$images = $_FILES['directions-image'];

		for($i = 0; $i < count($names); $i++) {
			$direction->recipe_id = $recipe_id;
			$direction->name = $names[$i];
			$direction->text = $texts[$i];
			$direction->note = trim($notes[$i]) ?: null;
			$direction->display_order = $i;

			if($images['name'][$i]) {
				$imgs = new ImageHelper;
				$img = $images['tmp_name'][$i];

				$upload_ok = $imgs->verifyImage($img);

				if($upload_ok) {
					$img_name = Web::instance()->slug($names[$i]);
					$imgs->directionImage($img, $recipe_id, $img_name);

					$direction->image = $img_name;
				}
			}

			$direction->insert();
			$direction->reset();
		}
	}

	private function addImages($recipe_id)
	{
		if($_FILES['main-image']['name']) {

			$images = new ImageHelper;
			$main_img = $_FILES['main-image']['tmp_name'];

			$upload_ok = $images->verifyImage($main_img);

			if($upload_ok) {
				$results = $images->recipeMainImage($main_img, $recipe_id);

				return $results;
			}
		}
	}
}
