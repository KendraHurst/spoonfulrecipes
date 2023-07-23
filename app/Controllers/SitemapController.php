<?php

namespace Controllers;

use View;
use Models\Recipe;

class SitemapController 
{
	public function generate_sitemap($f3)
	{
		$view = View::instance();
		$recipe_mapper = new Recipe();

		$recipes = $recipe_mapper->select('id, name', array('active ORDER BY publish_date DESC'));

		echo $view->render('sitemap.php', 'text/xml', compact('f3', 'view', 'recipes'));
	}
}
