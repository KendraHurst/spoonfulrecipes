<?php

namespace Controllers;

use View;

class ErrorController 
{
    public function error($f3) {
		$view = View::instance();

		if ($f3->get('ERROR.code') == 404) {
			$message = "404 Page Not Found";
		} else {
			$message = "Sorry, something went wrong";
		}

		echo $view->render('404.php', null, compact('f3', 'view', 'message'));
    }
}
