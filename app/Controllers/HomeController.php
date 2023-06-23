<?php

namespace Controllers;

use View;

class HomeController 
{
    public function index($f3) {
		$view = View::instance();
		echo $view->render('home.php', null, compact('f3', 'view'));
    }
}
