<?php
$page = [
	'title' => 'Moderate Reviews',
	'description' => 'Moderate the reviews for spoonful recipes',
	'noindex' => true
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
	?>

<style>

input.status[type="radio"] {
	-webkit-appearance: none!important;
	-moz-appearance: none!important;
	appearance: none!important;
}
input.status[type="radio"]:checked + label::before {
	font: var(--fa-font-solid)!important;
	font-size: 24px!important;
}
.approve::before {
	font: var(--fa-font-regular);
	font-size: 24px!important;
	content: '\f058'
}
.deny::before {
	font: var(--fa-font-regular);
	font-size: 24px!important;
	content: '\f057'
}

</style>

<div class="container my-5">
<?php if (count($reviews) !== 0) { ?>

	<form>

<?php foreach(array_slice($reviews, 0, 10) as $key=>$review) { ?>

		<div class="row my-4">
			<input hidden name="review_id[]" value="<?=$review['id'];?>">

			<div class="card col-12 col-md-10">
				<div class="card-body">

					<h4 class="card-title"><?=$review['name'];?></h3>

					<div class="card-subtitle">
						Recipe: <?=$recipe->find(array('id = ?', $review['recipe_id']))[0]['name'];?>
					</div>
					<div class="card-subtitle text-primary">
						<?=str_repeat(
							'<i class="fa-solid fa-star"></i>',
							$review['rating']) . str_repeat('<i class="fa-regular fa-star"></i>',
							5 - $review['rating']);
						?>
					</div>

					<p class="card-text"><?=$review['text'];?></p>

				</div>
			</div>

			<div class="col-12 col-md-2 my-auto text-primary">

				<input class="status" type="radio" name="status-<?=$review['id'];?>" value="1" id="approve-<?=$key;?>" required>
				<label class="approve" for="approve-<?=$key;?>"></label>

				<input class="status" type="radio" name="status-<?=$review['id'];?>" value="0" id="deny-<?=$key;?>">
				<label class="deny" for="deny-<?=$key;?>"></label>

			</div>

		</div>
<?php } ?>

		<input type="submit" class="btn btn-primary">
	</form>

<?php } else { ?>

		<div class="alert alert-primary" role="alert">
			All reviews checked!
		</div>

<?php } ?>
</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
