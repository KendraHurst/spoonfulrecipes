<?php

namespace Controllers;

use View;

class AboutController 
{
    public function about($f3) {
		$view = View::instance();

		echo $view->render('about.php', null, compact('f3', 'view'));
    }
}
