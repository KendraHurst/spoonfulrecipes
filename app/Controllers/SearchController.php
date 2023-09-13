<?php

namespace Controllers;

use View;

class SearchController 
{
    public function results($f3) {
		$view = View::instance();

		echo $view->render('results.php', null, compact('f3', 'view'));
    }
}

