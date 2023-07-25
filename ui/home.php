<?php
use Helpers\RatingHelper;

$rater = new RatingHelper();
$page = [
	'title' => 'Spoonful Recipes: Food is for Everyone',
	'description' => 'Spoonful Recipes is your destination for easy, accessible recipes',
	'canonical' => 'https://www.spoonfulrecipes.com'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<header class="header home-bg oswald d-flex flex-column text-center align-items-center justify-content-center">
	<h1 class="text-white">Spoonful Recipes</h1>
	<h2 class="text-light fs-2">Easy budget friendly recipes, one Spoonful at a time</h2>
</header>

<section>

	<h3 class="text-primary oswald fs-1 fw-bold mx-4 mx-md-5 my-3">Latest Recipes</h3>
	<div class="row mx-4 mx-md-5 my-3">

	<?php foreach($recipes as $recipe) {
		$slug = Web::instance()->slug($view->raw($recipe['name']));
		$ratings = [];
		foreach($reviews as $review) {
			if($review['recipe_id'] === $recipe['id']) {
				$ratings[] = $review['rating'];
			}
		}
		?>
		<div class="card recipe-card col-12 col-md-6 col-xl-3 border-0 p-1 p-xl-4 justify-between">
		  <picture>
		  	  <source srcset ="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.4x3.webp" type="image/webp">
			  <img src="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.4x3.jpg" class="card-img-top w-100 h-auto" alt="<?=$recipe['name'];?>" width="800" height="600">
		  </picture>
		  <div class="card-body text-center bg-light">
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

	</div>
</section>

<main class="mx-5">
	<div class="d-flex flex-md-row flex-column justify-around align-items-center">
		<picture>
			<source srcset="<?=$f3->get('imgurl');?>index/spoon-berry.webp" type="image/webp">
			<img src="<?=$f3->get('imgurl');?>index/spoon-berry.jpg" alt="Strawberry and spoonful of sugar" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image" width="700" height="700">
		</picture>
		<p class="m-4 m-md-5 fs-5">
		Welcome to Spoonful Recipes, your destination for delicious recipes that cater to ability and time constraints. We strive to provide recipes with clear instructions that anyone can make, with helpful tips for how to modify or substitute to make it work for you. Whether you're a busy professionial with limited time, a parent who has to figure out how to put a dinner on the table that will fit dietary restrictions, or trying to find recipes that will work with restrictions on your abilities, Spoonful Recipes has you covered. From meal prep recipes to help you get ahead, to quick dinners you can throw together on a busy night, we have a variety of recipes to help you get through your week. <a href="/recipes">Check out our recipes</a> to find one that will work for you!
		</p>
	</div>

	<!--<div class="d-flex flex-md-row-reverse flex-column justify-around align-items-center">
		<picture>
			<source srcset="<?=$f3->get('imgurl');?>index/spoonful-spices-1.webp" type="image/webp">
			<img src="<?=$f3->get('imgurl');?>index/spoonful-spices-1.jpg" alt="Spoons full of spices" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image" width="700" height="700">
		</picture>
		<p class="m-4 m-md-5 fs-5">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis iaculis est quis lectus posuere, sollicitudin porttitor tellus fringilla. Nam dictum, eros eget convallis dictum, magna quam fringilla erat, id finibus lorem diam mattis sem. Aenean nisl eros, tincidunt nec dictum congue, suscipit ac metus. Donec tristique, libero nec placerat cursus, magna nunc pellentesque leo, suscipit rhoncus ligula nibh nec nunc. Suspendisse eleifend accumsan nibh quis lacinia. Mauris tristique mauris risus, sit amet fermentum dolor fermentum iaculis. Maecenas vehicula rutrum ipsum, sed tempor elit. Mauris nulla lorem, sollicitudin vel metus sit amet, aliquam ultricies dui. In nec cursus nulla, sed ullamcorper arcu. Praesent sodales semper pulvinar. Cras nec quam sit amet justo rutrum consectetur.
		</p>
	</div>-->
</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
