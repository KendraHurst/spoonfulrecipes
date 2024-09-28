<?php
$page = [
	'title' => 'About Spoonful Recipes',
	'description' => 'Learn about the team behind Spoonful Recipes',
	'canonical' => 'https://www.spoonfulrecipes.com/about',
	'preload' => [
		'href' => 'https://spoonful-recipes.s3.us-east-2.amazonaws.com/about/about-bg-sm.webp',
		'as' => 'image'
	]
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<main id="main" class="container my-5" style="min-height:60vh">
	<h1 class="text-primary oswald fs-1"><?=$message;?></h1>
	<a href="/" class="btn btn-primary rounded pill px-3">Go Back to Homepage</a>
</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
