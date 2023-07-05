<?php

namespace Models;

use Models\Reviews;

class ReviewProcessor 
{
	public function add_review($f3)
	{
		$review = new Reviews();
		$audit = \Audit::instance();

		$page = $_POST['recipe-page'] ?: '';

		$review->recipe_id = $_POST['recipe-id'];
		$review->rating = $_POST['review-rating'];
		$review->name = substr($_POST['review-name'], 0, 255) ?: null;
		$review->email = $audit->email($_POST['review-email']) ? $_POST['review-email'] : null;
		$review->text = substr(htmlspecialchars($_POST['review-content']), 0, 5000) ?: null;

		$review->insert();

		header('Location: http://localhost:8000/recipes/' . $page);
	}
}
