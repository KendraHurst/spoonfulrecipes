<?php
$page = [
	'title' => 'About Spoonful Recipes',
	'description' => 'Learn about the team behind Spoonful Recipes',
	'canonical' => 'https://www.spoonfulrecipes.com/about'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<header class="header about-bg oswald d-flex flex-column text-center align-items-center justify-content-center">

	<h1 class="text-white mx-2">About Us</h1>
	<h2 class="text-light fs-2 mx-2">The team behind our recipes</h2>

</header>

<main class="mx-md-5 mx-1">

	<div class="d-flex flex-md-row-reverse flex-column justify-around align-items-center">

		<picture>
			<source srcset="<?=$f3->get('imgurl');?>about/spoonful-spices-2.webp" type="image/webp">
			<img src="<?=$f3->get('imgurl');?>about/spoonful-spices-2.jpg" alt="Strawberry and spoonful of sugar" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image"/>
		</picture>

		<div class="m-3 m-md-5 fs-5">
			<h3 class="oswald">Our Mission</h3>
			<p class="m-3 m-md-5 fs-5">
			Here at Spoonful Recipes, our commitment to accessibility is one of our top priorities. Because of this, we'll always strive to list alternative methods and substitutions you can make to our recipes in our recipes' content. While we strive to cover a broad range of restrictions, unfortunately we aren't able to cover everything. If you have an idea for how we can make our website or recipes more accessible, please feel free to reach out and let us know, and if it's feasible with our resources, we'd be happy to implement it.
			</p>
		</div>

	</div>

	<div class="d-flex flex-md-row flex-column justify-around align-items-center">

		<picture>
			<source srcset="<?=$f3->get('imgurl');?>about/profile.webp" type="image/webp">
			<img src="<?=$f3->get('imgurl');?>about/profile.jpg" alt="Spoons full of spices" class="my-md-5 my-4 px-md-5 px-4 w-100 h-auto content-image"/>
		</picture>

		<div class="m-4 m-md-5 fs-5">
			<h3 class="oswald">Hi! I'm Kendra</h3>
			<p class="m-4 m-md-5 fs-5">
			I'm the creator of Spoonful Recipes. When I was diagnosed with multiple chronic illnesses, I found that many recipes had to be modified to work with my new level of ability, or couldn't be made at all anymore. After a period of adjustment, I developed recipes and alternatives that work with me instead of against me. I developed a new passion for delicious, accessible food, so I made this website so I could share my recipes and give ideas about how to make cooking work for you. Food is for everyone, so our mission here at Spoonful Recipes is to deliver recipes you can make even if you have restrictions on your time or abilities.
			</p>
		</div>

	</div>

</main>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
