<?php
$page = [
	'title' => 'A Title',
	'description' => 'A description',
	'canonical' => 'https://www.spoonfulrecipes.com'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<header class="header recipe-bg oswald d-flex flex-column text-center align-items-center justify-content-center">
	<h1 class="text-white">Recipes</h1>
	<h2 class="text-light fs-2">A list of recipes by Spoonful</h2>
</header>

<main class="row">
<?php foreach ($recipes as $recipe) {
	$slug = Web::instance()->slug($recipe['name']);
	?>

	<div class="card recipe-card col-12 col-md-4 col-xl-3 border-0 p-4">
	  <img src="/images/recipes/<?=$slug;?>/sized/main.4x3.jpg" class="card-img-top" alt="<?=$recipe['name'];?>">
	  <div class="card-body text-center bg-light rounded-bottom">
		<h3 class="card-title oswald"><?=$recipe['name'];?></h3>
	  </div>
	  <div class="card-footer text-center border-0 bg-light rounded-bottom">
		<p class="card-text text-start"><?=$recipe['description'];?></p>
		<a href="recipes/<?=$slug;?>" class="btn btn-primary rounded-pill px-3">Go to Recipe</a>
	  </div>
	</div>	

<?php } ?>

</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
