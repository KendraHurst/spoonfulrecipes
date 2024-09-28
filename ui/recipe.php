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

<section id="main" aria-label="recipe navigation" class="d-flex justify-content-center d-print-none">
	<button role="button" class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" onclick="window.print()">Print Recipe</button>
	<a class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" href="#recipe-section">Jump to Recipe</a>
</section>

<div class="container">

	<div class="col-12">
		<section aria-label="recipe content" class="recipe-content my-4 my-md-5 d-print-none">
		<?=$view->raw($recipe['content']);?>

        <?php
        if ($recipe['video']) {
        ?>
        <h3>Video</h3>
        <iframe src="<?=$recipe['video'];?>" loading="lazy" title="<?=$recipe['name'];?> video" width="560" height="315">
            <a href="<?=$recipe['video'];?>" target="_blank">View Video (opens in a new tab)</a>
        </iframe>
        <?php
        }?>
		</section>

		<!-- AddToAny BEGIN -->
		<section aria-label="social sharing" class="a2a_kit a2a_kit_size_32 a2a_default_style d-print-none ms-2">
			<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
			<a class="a2a_button_copy_link"></a>
			<a class="a2a_button_email"></a>
			<a class="a2a_button_print"></a>
			<a class="a2a_button_facebook"></a>
			<a class="a2a_button_pinterest"></a>
			<a class="a2a_button_twitter"></a>
		</section>
		<!-- AddToAny END -->

		<main id="recipe-section" class="row my-4 mx-2 my-md-5 rounded-3 bg-light fs-5">
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

				<p class="m-0"><span style="font-weight:bold">Author: </span><?=$author;?></p>
				<p class="m-0"><span style="font-weight:bold">Publish Date: </span><?=date("M j, Y", strtotime($recipe['publish_date']));?></p>
				<p class="m-0"><span style="font-weight:bold">Prep Time: </span><?=$recipe['prep_time'];?> min</p>
				<p class="m-0"><span style="font-weight:bold">Cook Time: </span><?=$recipe['cook_time'];?> min</p>
				<p class="m-0"><span style="font-weight:bold">Total Time: </span><?=$recipe['prep_time'] + $recipe['cook_time'];?> min</p>
				<p class="m-0"><span style="font-weight:bold">Yield: </span><?=$recipe['yield'];?></p>
				<?php if(isset($recipe['calories'])) { ?>
				<p class="m-0"><span style="font-weight:bold">Calories: </span><?=$recipe['calories'];?></p>
				<?php }
				if(isset($recipe['category'])) { ?>
				<p class="m-0"><span style="font-weight:bold">Type: </span><?=ucwords($recipe['category']);?></p>
				<?php } ?>
			</div>
			<div class="col-12 col-md-6 px-3 px-4 px-md-4 pt-md-4">
				<h4>Ingredients</h4>
				<ul class="my-3 list-group list-group-flush">
				<?php foreach ($ingredients as $ingredient) { ?>
					<li class="list-group-item px-0 bg-light">
					<span style="font-weight:bold"><?=$ingredient['measure'];?></span>
                    <?=$ingredient['ingredient'];?>

					<?php
                    if($ingredient['alternative']) {
                    ?>
                    <span style="font-weight:bold">or</span>
                    <?=$ingredient['alternative'];?>
                    <?php
                    }

					if($ingredient['note']) {
						$notes[] = $ingredient['note'];
                        ?>
						<sup>
                            <a
                                id="note-<?=count($notes);?>"
                                aria-label="jump to footnote <?=count($notes);?>"
                                href="#footnote-<?=count($notes);?>"
                            >
                                <?=count($notes);?>
                            </a>
                        </sup>
                        <?php
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
                        ?>
						<sup>
                            <a
                                id="note-<?=count($notes);?>"
                                aria-label="jump to footnote <?=count($notes);?>"
                                href="#footnote-<?=count($notes);?>"
                            >
                                <?=count($notes);?>
                            </a>
                        </sup>
                        <?php
					} ?>
					</li>
					<?php } ?>
				</ol>
			</div>
			<?php if ($notes) { ?>
			<div class="col-12 px-3 pt-3 px-md-4 pt-md-4">
				<h4>Notes</h5>
				<?php foreach($notes as $key=>$note) { ?>
					<p id="footnote-<?=($key + 1);?>">
                        <sup><?=($key + 1);?></sup> <?=$note;?>
                        <a class="d-print-none" href="#note-<?=($key + 1);?>" aria-label="Back to recipe">
                            <i class="fa-solid fa-turn-up"></i>
                        </a>
                    </p>
				<?php } ?>
			</div>
			<?php } ?>
		</main>

		<section aria-label="leave a review" class="mx-2 my-4 d-print-none">
	<?php if (isset($_GET['submitted'])) { ?>

		<div class="alert alert-primary d-print-none" id="review-reply" role="alert">
			Thank you for your review!
		</div>

	<?php } else { ?>

            <h3 class="mb-3" id="review-title">Leave a Review</h3>
			<form action="/add-review" method="post" id="review-form" aria-labelledby="review-title">
				<input hidden name="recipe-id" value="<?=$recipe['id'];?>">
				<input hidden name="recipe-page" value="<?=Web::instance()->slug($recipe['name']);?>">

				<fieldset class="star-rating form-check-inline text-primary mb-3">
                    <legend class="form-label text-black">Star Rating*</legend>
					<input class="rating m-0 p-0" type="radio" name="review-rating" value="1" id="rating-1" required>
					<label for="rating-1" class="rating-star"><span class="visually-hidden">1 star</span></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="2" id="rating-2" required>
					<label for="rating-2" class="rating-star"><span class="visually-hidden">2 stars</span></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="3" id="rating-3" required>
					<label for="rating-3" class="rating-star"><span class="visually-hidden">3 stars</span></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="4" id="rating-4" required>
					<label for="rating-4" class="rating-star"><span class="visually-hidden">4 stars</span></label>

					<input class="rating m-0 p-0" type="radio" name="review-rating" value="5" id="rating-5" required>
					<label for="rating-5" class="rating-star"><span class="visually-hidden">5 stars</span></label>
				</fieldset>
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
		<section aria-label="reviews" class="mx-2 my-4 d-print-none">
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

	const reviewForm = document.getElementById("review-form");

	reviewForm.addEventListener('input', () => {

		const captchaScript = document.createElement('script');
		const body = document.querySelector('body');

		captchaScript.setAttribute('async', '');
		captchaScript.setAttribute('defer', '');
		captchaScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js');

		body.appendChild(captchaScript);
	},
	{ once: true });
</script>
<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
