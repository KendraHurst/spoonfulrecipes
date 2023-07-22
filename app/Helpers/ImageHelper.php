<?php

namespace Helpers;

use Base;
use Image;
use Aws\S3\S3Client;

class ImageHelper
{
	private function uploadImage($image, $location, $type)
	{
		$s3 = new S3Client([
			'region'  => 'us-east-2',
			'version' => 'latest',
		]);

		$result = $s3->putObject([
			'Bucket'=>'spoonful-recipes',
			'Key'=>$location,
			'Body'=>$image,
			'ContentType'=>$type
		]);

		return $result;
	}
	public function recipeMainImage($image, $recipe_id)
	{
		$location = 'recipes/' . $recipe_id . '/';
		$main = new Image($image, true, '');

		$main->resize(1920, 1080, true, true);
		$mainDesktop = $main->dump('jpeg', 75);
		$mainDesktopWeb = $main->dump('webp', 75);

		$main->restore();

		$main->resize(800, 800, true, true);
		$mainSquare = $main->dump('jpeg', 75);
		$mainSquareWeb = $main->dump('webp', 75);

		$main->resize(800, 600, true, true);
		$mainDisplay = $main->dump('jpeg', 75);
		$mainDisplayWeb = $main->dump('webp', 75);

		$results = array();

		$results[] = $this->uploadImage($mainDesktop, $location . 'main.16x9.jpg', 'image/jpeg');
		$results[] = $this->uploadImage($mainDesktopWeb, $location . 'main.16x9.webp', 'image/webp');
		$results[] = $this->uploadImage($mainSquare, $location . 'main.1x1.jpg', 'image/jpeg');
		$results[] = $this->uploadImage($mainSquareWeb, $location . 'main.1x1.webp', 'image/webp');
		$results[] = $this->uploadImage($mainDisplay, $location . 'main.4x3.jpg', 'image/jpeg');
		$results[] = $this->uploadImage($mainDisplayWeb, $location . 'main.4x3.webp', 'image/webp');

		return $results;
	}
	public function directionImage($image, $recipe_id, $direction_id)
	{
	}
}
