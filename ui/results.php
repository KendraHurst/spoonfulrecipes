<?php
$page = [
	'title' => 'Spoonful Recipes Search Results',
	'description' => 'Search for Recipes on our Website',
	'noindex' => true
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<header class="header about-bg oswald d-flex flex-column text-center align-items-center justify-content-center">

	<h1 class="text-white mx-2">Search Results</h1>

</header>

<script async src="https://cse.google.com/cse.js?cx=640663e4f4e17494c">
</script>

<div class="m-2" style="min-height:200px;">
	<div class="gcse-searchresults-only"></div>
</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
