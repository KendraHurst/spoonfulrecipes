<?php

namespace Helpers;

use Web;

class SchemaHelper
{
	public function recipeSchema($f3, $recipe, $ingredients, $directions, $author, $reviews)
	{
		$recipe_slug = Web::instance()->slug($recipe['name']);

		$schema_array = [
			"@context" => "https://schema.org/",
			"@type" => "Recipe",
			"name" => $recipe['name'],
			"image" => [
				$f3->get('siteurl') . "/images/recipes/" . $recipe_slug . "/sized/main.1x1.jpg",
				$f3->get('siteurl') . "/images/recipes/" . $recipe_slug . "/sized/main.4x3.jpg",
				$f3->get('siteurl') . "/images/recipes/" . $recipe_slug . "/sized/main.16x9.jpg"
			],
			"author" => [
				"@type" => "Person",
				"name" => $author
			],
			"datePublished" => $recipe['publish_date'],
			"description" => $recipe['description'],
			"prepTime" => "PT" . $recipe['prep_time'] . "M",
			"cookTime" => "PT" . $recipe['cook_time'] . "M",
			"totalTime" => "PT" . ($recipe['prep_time'] + $recipe['cook_time']) . "M",
			"recipeYield" => $recipe['yield']
		];

		if($recipe['keywords']) {
			$schema_array['keywords'] = $recipe['keywords'];
		}

		if($recipe['category']) {
			$schema_array['recipeCategory'] = $recipe['category'];
		}

		if($recipe['cuisine']) {
			$schema_array['recipeCuisine'] = $recipe['cuisine'];
		}

		if($recipe['calories']) {
			$schema_array['nutrition'] = [
				"@type" => "NutritionInformation",
				"calories" => $recipe['calories'] . " calories"
			];
		}

		$schema_array['recipeIngredient'] = $this->ingredientSchema($ingredients);

		$schema_array['recipeInstructions'] = $this->directionSchema($directions, $f3->get('siteurl') . '/recipes/' . $recipe['id'] . '/' . $recipe_slug);

		if($reviews) {
			$schema_array['aggregateRating'] = $this->ratingSchema($reviews);
		}

		return json_encode($schema_array, JSON_PRETTY_PRINT);

	}

	private function ingredientSchema($ingredients)
	{
		$schema = array();

		foreach($ingredients as $ingredient) {
			$schema[] = $ingredient['measure'] . ' ' . $ingredient['ingredient'];
		}

		return $schema;
	}

	private function directionSchema($directions, $page)
	{
		$schema = array();

		foreach($directions as $key=>$direction) {
			$direction_array = [
				"@type" => "HowToStep",
				"name" => $direction['name'],
				"text" => $direction['text'],
				"url" => $page. "#step" . ($key + 1)
			];

			if($direction['image']) {
				$direction_array['image'] = $direction['image'];
			}

			$schema[] = $direction_array;
		}

		return $schema;
	}

	private function ratingSchema($reviews)
	{
		$schema = [
			"@type"=>"AggregateRating"
		];

		$ratings = [];

		foreach($reviews as $review) {
			$ratings[] = $review['rating'];
		}

		$schema['ratingValue'] = round(array_sum($ratings) / count($ratings), 1);

		$schema['ratingCount'] = count($reviews);

		return $schema;
	}

	private function recipeVideoSchema($video)
	{
		//Add stuff here when you implement videos
	}
}
