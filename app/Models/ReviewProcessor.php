<?php

namespace Models;

use Models\Reviews;
use Helpers\CaptchaHelper;

class ReviewProcessor 
{
	public function add_review($f3)
	{
		$audit = \Audit::instance();
		$captcha = new CaptchaHelper;
		$page = $_POST['recipe-page'] ? $_POST['recipe-page'] . '?submitted=1#review-reply' : '';

		if($audit->isbot()) {

			return $page;

		} else if ($captcha->verifyCaptcha($f3, $_POST['g-recaptcha-response'])) {
			$review = new Reviews();

			$review->recipe_id = $_POST['recipe-id'];
			$review->rating = $_POST['review-rating'];
			$review->name = substr($_POST['review-name'], 0, 255) ?: null;
			$review->email = $audit->email($_POST['review-email']) ? $_POST['review-email'] : null;
			$review->text = substr(htmlspecialchars($_POST['review-content']), 0, 5000) ?: null;

			$review->insert();

			return $page;
		} else {
			return $page;
		}
	}
}
