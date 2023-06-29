<?php

namespace Models;

use Models\Recipes;
use Models\Ingredients;
use Models\Directions;

class AddRecipe 
{
	public function addRecipe($f3)
	{
		print_r($_POST);
	}

	private function addIngredients($measures, $ingredients, $notes)
	{
	}

	private function addDirections($names, $texts, $notes)
	{
	}

	private function addImages($image)
	{
		//Put stuff here once you set up S3
	}
}
