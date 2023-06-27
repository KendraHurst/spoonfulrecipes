<?php
$page = [
	'title' => 'A Title',
	'description' => 'A description',
	'canonical' => 'https://www.frugalspoonful.com'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<header class="header home-bg oswald d-flex flex-column text-center align-items-center justify-content-center mt-5">
	<h1 class="text-white">Frugal Spoonful</h1>
	<h2 class="text-light fs-2">Easy frugal recipes, one Spoonful at a time</h2>
</header>

<section>

	<h3 class="text-primary oswald fs-1 fw-bold mx-4 mx-md-5 my-3">Latest Recipes</h3>
	<div class="row mx-4 mx-md-5 my-3">

	<?php foreach($recipes as $recipe) {
		$slug = Web::instance()->slug($recipe['name']);
		?>
		<div class="card recipe-card col-12 col-md-6 col-xl-3 border-0 p-1 p-xl-4 justify-between">
		  <img src="/images/recipes/<?=$slug;?>/sized/main.4x3.jpg" class="card-img-top" alt="Congee">
		  <div class="card-body text-center bg-light">
			<h3 class="card-title oswald"><?=$recipe['name'];?></h3>
		  </div>
		  <div class="card-footer text-center border-0 bg-light rounded-bottom">
			<p class="card-text text-start"><?=$recipe['description'];?></p>
			<a href="recipes/<?=$slug;?>" class="btn btn-primary rounded-pill px-3">Go to Recipe</a>
		  </div>
		</div>	
	<?php } ?>

	</div>
</section>

<main>
	<div class="d-flex flex-md-row flex-column justify-around align-items-center">
		<img src="/images/index/spoon-berry.jpg" alt="Strawberry and spoonful of sugar" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image"/>
		<p class="m-4 m-md-5 fs-5">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis iaculis est quis lectus posuere, sollicitudin porttitor tellus fringilla. Nam dictum, eros eget convallis dictum, magna quam fringilla erat, id finibus lorem diam mattis sem. Aenean nisl eros, tincidunt nec dictum congue, suscipit ac metus. Donec tristique, libero nec placerat cursus, magna nunc pellentesque leo, suscipit rhoncus ligula nibh nec nunc. Suspendisse eleifend accumsan nibh quis lacinia. Mauris tristique mauris risus, sit amet fermentum dolor fermentum iaculis. Maecenas vehicula rutrum ipsum, sed tempor elit. Mauris nulla lorem, sollicitudin vel metus sit amet, aliquam ultricies dui. In nec cursus nulla, sed ullamcorper arcu. Praesent sodales semper pulvinar. Cras nec quam sit amet justo rutrum consectetur.
		</p>
	</div>

	<div class="d-flex flex-md-row-reverse flex-column justify-around align-items-center">
		<img src="/images/index/spoonful-spices-1.jpg" alt="Spoons full of spices" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image"/>
		<p class="m-4 m-md-5 fs-5">
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis iaculis est quis lectus posuere, sollicitudin porttitor tellus fringilla. Nam dictum, eros eget convallis dictum, magna quam fringilla erat, id finibus lorem diam mattis sem. Aenean nisl eros, tincidunt nec dictum congue, suscipit ac metus. Donec tristique, libero nec placerat cursus, magna nunc pellentesque leo, suscipit rhoncus ligula nibh nec nunc. Suspendisse eleifend accumsan nibh quis lacinia. Mauris tristique mauris risus, sit amet fermentum dolor fermentum iaculis. Maecenas vehicula rutrum ipsum, sed tempor elit. Mauris nulla lorem, sollicitudin vel metus sit amet, aliquam ultricies dui. In nec cursus nulla, sed ullamcorper arcu. Praesent sodales semper pulvinar. Cras nec quam sit amet justo rutrum consectetur.
		</p>
	</div>
</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
