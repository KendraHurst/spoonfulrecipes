<?php
use Helpers\RatingHelper;

$rater = new RatingHelper();
$page = [
	'title' => 'Recipes list for Spoonful Recipes',
	'description' => 'Check out all the great recipes available at Spoonful Recipes',
	'canonical' => 'https://www.spoonfulrecipes.com/recipes',
	'preload' => [
		'href' => 'https://spoonful-recipes.s3.us-east-2.amazonaws.com/recipes/recipe-bg-sm.webp',
		'as' => 'image'
	]
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
	$slug = Web::instance()->slug($view->raw($recipe['name']));
	$ratings = [];
	foreach($reviews as $review) {
		if($review['recipe_id'] === $recipe['id']) {
			$ratings[] = $review['rating'];
		}
	}
	?>

	<div class="card recipe-card col-12 col-md-4 col-xl-3 border-0 p-4">
	  <picture>
	  	<source srcset="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.4x3.webp" type="image/webp">
		  <img src="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.4x3.jpg" class="card-img-top w-100 h-auto" alt="<?=$recipe['name'];?>" width="800" height="600">
	  </picture>
	  <div class="card-body text-center bg-light rounded-bottom">
		<h3 class="card-title oswald"><?=$recipe['name'];?></h3>
	<?php if ($ratings) {
		echo $rater->starsPlusRating($ratings);
	} ?>
	  </div>
	  <div class="card-footer text-center border-0 bg-light rounded-bottom pb-3">
		<p class="card-text text-start"><?=$recipe['description'];?></p>
		<a href="recipes/<?=$recipe['id'];?>/<?=$slug;?>" class="btn btn-primary rounded-pill px-3">Go to Recipe</a>
	  </div>
	</div>	

<?php } ?>

</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
