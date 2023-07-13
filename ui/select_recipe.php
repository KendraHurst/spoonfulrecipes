<?php
$page = [
	'title' => 'Select a recipe to edit',
	'description' => 'Choose a recipe to edit',
	'noindex' => true
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
?>
<?php
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
	?>

<div class="container my-5">
	<form method="get">
		<div class="input-group mb-5">
			<input name="edit-recipe" list="recipe-list" class="form-control" type="text">
			<datalist id="recipe-list">
			<?php foreach($recipe_list as $recipe) { ?>
				<option value="<?=$recipe['id'];?>"><?=$recipe['name'];?></option>
			<?php } ?>
			</datalist>
			<input type="submit" value="Submit" class="btn btn-primary">
		</div>
	</form>
</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
