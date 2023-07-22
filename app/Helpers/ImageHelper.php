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
	public function verifyImage($image)
	{
		$size = filesize($image);

		if($size === false) {
			return false;
		}

		if ($size > 2000000) {
			return false;
		}

		$image_type = exif_imagetype($image);

		if ($image_type != 2 && $image_type != 3 && $image_type != 18 && $image_type != 1) {
			return false;
		}

		return true;
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
	public function directionImage($image, $recipe_id, $img_name)
	{
		$location = 'recipes/' . $recipe_id . '/directions/';
		$dir_img = new Image($image, true, '');

		$dir_img->resize(800, 600, true, true);
		$dir_jpg = $dir_img->dump('jpeg', 75);
		$dir_webp = $dir_img->dump('webp', 75);

		$results = array();

		$results[] = $this->uploadImage($dir_jpg, $location . $img_name . '.jpg', 'image/jpeg');
		$results[] = $this->uploadImage($dir_webp, $location . $img_name . '.webp', 'image/webp');
	}
}
