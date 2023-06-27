<?php
$page = [
	'title' => $recipe['title'],
	'description' => $recipe['description'],
	'canonical' => 'https://www.frugalspoonful.com/recipes/' . Web::instance()->slug($recipe['name']),
	'keywords' => $recipe['keywords'] ?: ''
];

$notes = [];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
?>

<style>
	.recipe-page-bg {
		background-image:url('/images/recipes/<?=$recipe_slug;?>/sized/main.bg.jpg');
	}

	@media screen and (max-width: 767px) {
		.recipe-page-bg {
			background-image:url('/images/recipes/<?=$recipe_slug;?>/sized/main.bg-sm.jpg');
		}
	}
</style>

<header class="header recipe-page-bg oswald d-flex flex-column text-center align-items-center justify-content-center d-print-none">
	<h1 class="text-white"><?=$recipe['name'];?></h1>
	<h2 class="text-light fs-2"><?=$recipe['title'];?></h2>
</header>

<div class="d-flex justify-content-center d-print-none">
	<button class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" onclick="window.print()">Print Recipe</button>
	<button class="btn btn-primary rounded-pill fw-bold px-3 my-4 mx-2" onclick="document.getElementById('recipe-section').scrollIntoView({behavior: 'smooth'})">Jump to Recipe</button>
</div>

<div class="row">

	<div class="col-0 col-lg-1 col-xl-2">
	</div>

	<div class="col-12 col-lg-10 col-xl-8">
		<main class="recipe-content m-4 m-md-5 d-print-none">
		<?=Markdown::instance()->convert($recipe['content']);?>
		</main>

		<section id="recipe-section" class="row m-4 m-md-5 rounded-3 bg-light fs-5">
			<img src="/images/recipes/<?=$recipe_slug;?>/sized/main.1x1.jpg" class="col-12 col-md-6 p-3 p-md-4 h-auto" alt="<?=$recipe['name'];?>">
			<div class="col-12 col-md-6 p-3 p-md-4">
				<h3 class="oswlad fs-1 fw-bold text-primary mb-3"><?=$recipe['name'];?></h3>
				<p class="m-0"><b>Author: </b><?=$recipe['author'];?></p>
				<p class="m-0"><b>Prep Time: </b><?=$recipe['prep_time'];?> min</p>
				<p class="m-0"><b>Cook Time: </b><?=$recipe['cook_time'];?> min</p>
				<p class="m-0"><b>Total Time: </b><?=$recipe['prep_time'] + $recipe['cook_time'];?> min</p>
				<p class="m-0"><b>Yield: </b><?=$recipe['yield'];?></p>
				<?php if(isset($recipe['calories'])) { ?>
				<p class="m-0"><b>Calories: </b><?=$recipe['calories'];?></p>
				<?php }
				if(isset($recipe['category'])) { ?>
				<p class="m-0"><b>Type: </b><?=$recipe['category'];?></p>
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
					<li class="list-group-item px-0 bg-light" id="<?=$key;?>">
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
				<h5>Notes</h5>
				<?php foreach($notes as $key=>$note) { ?>
					<p><?=str_repeat('*', $key + 1) . $note;?></p>
				<?php } ?>
			</div>
			<?php } ?>
		<section>
	</div>

	<div class="col-0 col-lg-1 col-xl-2">
	</div>

</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
