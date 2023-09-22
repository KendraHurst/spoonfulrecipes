<?php
use Helpers\RatingHelper;
use Helpers\SchemaHelper;

$rater = new RatingHelper();
$schema = new SchemaHelper();

$page = [
	'title' => $recipe['title'],
	'description' => $recipe['description'],
	'canonical' => 'https://www.spoonfulrecipes.com/recipes/' . $recipe['id'] . '/' . Web::instance()->slug($recipe['name']),
	'preload' => [
		'href' => $f3->get('imgurl') . 'recipes/' . $recipe['id'] . '/main.1x1.webp',
		'as' => 'image'
	]
];

$notes = [];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>
<script type="application/ld+json">

	<?=$schema->recipeSchema($f3, $recipe, $ingredients, $directions, $author, $reviews);?>

</script>

<style>
	.no-webp .recipe-page-bg {
		background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>;?>/main.16x9.jpg');
		background-size: 100%;
		background-size: cover;
	}
	.webp .recipe-page-bg {
		background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.16x9.webp');
		background-size: 100%;
		background-size: cover;
	}

	@media screen and (max-width: 767px) {
		.no-webp .recipe-page-bg {
			background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.1x1.jpg');
			background-size: 100%;
			background-size: cover;
		}
		.webp .recipe-page-bg {
			background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.1x1.webp');
			background-size: 100%;
			background-size: cover;
		}
	}
</style>

<header class="header recipe-page-bg oswald d-flex flex-column text-center align-items-center justify-content-center d-print-none">
	<h1 class="text-white mx-2"><?=$recipe['name'];?></h1>
	<h2 class="text-light fs-2 mx-2"><?=$recipe['title'];?></h2>
</header>

<div class="container text-start d-print-none">
</div>
<div class="d-flex justify-content-center d-print-none">
	<button class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" onclick="window.print()">Print Recipe</button>
	<button class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" onclick="document.getElementById('recipe-section').scrollIntoView({behavior: 'smooth'})">Jump to Recipe</button>
</div>

<div class="container">

	<div class="col-12">
		<main class="recipe-content my-4 my-md-5 d-print-none">
		<?=$view->raw($recipe['content']);?>
		</main>

		<!-- AddToAny BEGIN -->
		<div class="a2a_kit a2a_kit_size_32 a2a_default_style d-print-none ms-2">
			<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
			<a class="a2a_button_copy_link"></a>
			<a class="a2a_button_email"></a>
			<a class="a2a_button_print"></a>
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_pinterest"></a>
			<a class="a2a_button_twitter"></a>
		</div>
		<!-- AddToAny END -->

		<section id="recipe-section" class="row my-4 mx-2 my-md-5 rounded-3 bg-light fs-5">
			<picture class="col-12 col-md-6">
				<source srcset="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.1x1.webp" type="image/webp">
				<img src="<?=$f3->get('imgurl');?>recipes/<?=$recipe['id'];?>/main.1x1.jpg" class="w-100 p-3 p-md-4 h-auto" alt="<?=$recipe['name'];?>">
			</picture>
			<div class="col-12 col-md-6 p-3 p-md-4">
				<h3 class="oswald fs-1 text-primary mb-3"><?=$recipe['name'];?></h3>

			<?php if($reviews) {
				$ratings = [];

				foreach($reviews as $review) {
					$ratings[] = $review['rating'];
				}
				echo $rater->starsPlusRating($ratings);
			} ?>

				<p class="m-0"><b>Author: </b><?=$author;?></p>
				<p class="m-0"><b>Publish Date: </b><?=date("M j, Y", strtotime($recipe['publish_date']));?></p>
				<p class="m-0"><b>Prep Time: </b><?=$recipe['prep_time'];?> min</p>
				<p class="m-0"><b>Cook Time: </b><?=$recipe['cook_time'];?> min</p>
				<p class="m-0"><b>Total Time: </b><?=$recipe['prep_time'] + $recipe['cook_time'];?> min</p>
				<p class="m-0"><b>Yield: </b><?=$recipe['yield'];?></p>
				<?php if(isset($recipe['calories'])) { ?>
				<p class="m-0"><b>Calories: </b><?=$recipe['calories'];?></p>
				<?php }
				if(isset($recipe['category'])) { ?>
				<p class="m-0"><b>Type: </b><?=ucwords($recipe['category']);?></p>
				<?php } ?>
			</div>
			<div class="col-12 col-md-6 px-3 px-4 px-md-4 pt-md-4">
				<h4>Ingredients</h4>
				<ul class="my-3 list-group list-group-flush">
				<?php foreach ($ingredients as $ingredient) { ?>
					<li class="list-group-item px-0 bg-light">
					<b><?=$ingredient['measure'];?></b> <?=$ingredient['ingredient'];?>
					<?php if($ingredient['note']) {
						$notes[] = $ingredient['note'];
						echo(str_repeat('*', count($notes)));
					} ?>
					</li>
				<?php } ?>
				</ul>
			</div>
			<div class="col-12 px-3 pt-3 px-md-4 pt-md-4">
				<h4>Directions</h4>
				<ol class="my-3 list-group list-group-flush list-group-numbered bg-light">
					<?php foreach ($directions as $key=>$direction) { ?>
					<li class="list-group-item px-0 bg-light" id="step<?=$key + 1;?>">
					<?=$direction['text'];?>
					<?php if($direction['note']) {
						$notes[] = $direction['note'];
						echo(str_repeat('*', count($notes)));
					} ?>
					</li>
					<?php } ?>
				</ol>
			</div>
			<?php if ($notes) { ?>
			<div class="col-12 px-3 pt-3 px-md-4 pt-md-4">
				<h4>Notes</h5>
				<?php foreach($notes as $key=>$note) { ?>
					<p><?=str_repeat('*', $key + 1) . ' ' . $note;?></p>
				<?php } ?>
			</div>
			<?php } ?>
		</section>

	<?php if (isset($_GET['submitted'])) { ?>

		<div class="alert alert-primary d-print-none" id="review-reply" role="alert">
			Thank you for your review!
		</div>

	<?php } else { ?>

		<section class="mx-2 my-4 d-print-none">
			<h3 class="mb-3">Leave a Review</h2>
			<form action="/add-review" method="post" id="review-form">
				<input hidden name="recipe-id" value="<?=$recipe['id'];?>">
				<input hidden name="recipe-page" value="<?=Web::instance()->slug($recipe['name']);?>">

				<div class="form-label">Star Rating*</div>
				<div class="star-rating form-check-inline text-primary mb-3">
					<input class="rating m-0 p-0" type="radio" name="review-rating" value="1" id="rating-1" aria-label="1 star" required>
					<label for="rating-1" class="rating-star"></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="2" id="rating-2" aria-label="2 stars" required>
					<label for="rating-2" class="rating-star"></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="3" id="rating-3" aria-label="3 stars" required>
					<label for="rating-3" class="rating-star"></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="4" id="rating-4" aria-label="4 stars" required>
					<label for="rating-4" class="rating-star"></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="5" id="rating-5" aria-label="5 stars" required>
					<label for="rating-5" class="rating-star"></label>
				</div>
				<br />

				<div class="row">
					<label for="review-name" class="form-label col-6">
						Name*
						<input name="review-name" id="review-name" class="form-control mb-3" type="text" maxlength="200" required>
					</label>

					<label for="review-email" class="form-label col-6">
						Email*
						<input name="review-email" id="review-email" class="form-control mb-3" type="email" maxlength="200" required>
					</label>
				</div>

				<label for="review-content" class="form-label">Content</label>
				<textarea name="review-content" id="review-content" placeholder="Write a review..." class="form-control mb-4" rows="5" maxlength="5000"></textarea>
				<div class="mb-4">
					This site is protected by reCAPTCHA and the Google
					<a href="https://policies.google.com/privacy">Privacy Policy</a> and
					<a href="https://policies.google.com/terms">Terms of Service</a> apply.
				</div>

				<button
					class="g-recaptcha btn btn-primary"
					data-sitekey="6LcUGgEnAAAAACCR1Yv5AP5jAuzeLJojFdqJcmwf"
					data-callback='onSubmit'
					data-action='submit'
				>
					Submit
				</button>

			</form>
		</section>

	<?php }
	if($reviews) { ?>
		<section class="mx-2 my-4 d-print-none">
			<h3 class="mb-3">Reviews</h2>

		<?php foreach ($reviews as $review) { ?>
			<div class="card col-12">
				<div class="card-body">
					<h4 class="card-title"><?=$review['name'];?></h4>
					<div class="card-subtitle"><?=date("M j, Y", strtotime($review['date']));?></div>
					<div class="card-subtitle text-primary"><?=str_repeat('<i class="fa-solid fa-star"></i>', $review['rating']) . str_repeat('<i class="fa-regular fa-star"></i>', 5 - $review['rating']);?></div>
					<p class="card-text"><?=$review['text'];?></p>
				</div>
			</div>
		<?php } ?>

		</section>
	<?php } ?>
	</div>
</div>

<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
	function onSubmit(token) {
		document.getElementById("review-form").requestSubmit();
	}

	window.addEventListener('load', (event) => {
		const captchaScript = document.createElement('script');
		const body = document.querySelector('body');

		captchaScript.setAttribute('async', '');
		captchaScript.setAttribute('defer', '');
		captchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js');

		body.appendChild(captchaScript);
	});
</script>
<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
