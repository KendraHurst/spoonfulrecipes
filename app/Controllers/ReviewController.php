<?php

namespace Controllers;

use View;
use Models\ReviewProcessor;
use Models\Reviews;
use Models\Recipe;

class ReviewController 
{
	public function process_review($f3)
	{
		$process = new ReviewProcessor();
		$page = $process->add_review($f3);

		header('Location: ' . $f3->get('siteurl') . '/recipes/' . $page);
		die();
	}
	public function check_reviews($f3)
	{
		if(isset($_SESSION['user'])) {

			$review_mapper = new Reviews();

			if(isset($_GET['review_id'])) {

				foreach($_GET['review_id'] as $review) {

					$review_mapper->load(array('id = ?', $review));
					$review_mapper->approved = $_GET['status-' . $review];
					$review_mapper->checked = 1;

					$review_mapper->update();
					$review_mapper->reset();
				}

				header('Location: ' . $f3->get('siteurl') . '/check-reviews');
				die();

			} else {

				$recipe = new Recipe();
				$reviews = $review_mapper->find('checked=0');

				$view = View::instance();
				echo $view->render('check_reviews.php', null, compact('f3', 'view', 'reviews', 'recipe'));
			}
		} else {
			header('Location: ' . $f3->get('siteurl') . '/login?from=check-reviews');
		}
	}
}
