<?php

namespace Controllers;

use View;

class TermsController 
{
	public function terms($f3)
	{
		$view = View::instance();
		echo $view->render('terms.php', null, compact('f3', 'view'));
	}
	public function privacy($f3)
	{
		$view = View::instance();
		echo $view->render('privacy.php', null, compact('f3', 'view'));
	}
}
