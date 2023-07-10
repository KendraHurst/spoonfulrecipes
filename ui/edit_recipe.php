<?php
$page = [
	'title' => 'Edit a recipe on Spoonful Recipes',
	'description' => 'Fill out the form to edit the recipe',
	'canonical' => 'https://www.spoonfulrecipes.com'
];

$f3->set('page', $page);
$categories = explode(', ', $recipe['category']);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
	?>
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
<script src="https://kit.fontawesome.com/d6ec043418.js" crossorigin="anonymous"></script>
<script src="js/new_recipe.js"></script>
<style>
	#directions-list .btn, #directions-list input {
		line-height: 48px;
	}
	#directions-list {
		counter-reset: direction;
	}
	#directions-list .input-group {
		counter-increment: direction;
	}
	#directions-list .input-group::before {
		content: counter(direction)". ";
		line-height: 62px;
		margin-right: 10px;
	}
	.ck-content {
		height: 300px;
	}
</style>

<div style="height: 100px;">
</div>

<div class="container">
	<form action="update-recipe" method="post">

		<input hidden value="<?=$recipe['id'];?>" name="recipe_id">

		<label for="name" class="form-label">Name<span style="color:red;">*</span></label>
		<input type="text" name="name" maxlength="100" class="form-control mb-3" value="<?=$recipe['name'];?>" required>

		<label for="author" class="form-label">Author</label>
		<input type="text" name="author" class="form-control mb-3" value="<?=$author['name'];?>" readonly>

		<label for="title" class="form-label">Title<span style="color:red;">*</span></label>
		<input type="text" name="title" maxlength="150" class="form-control mb-3" value="<?=$recipe['title'];?>" required>

		<label for="description" class="form-label">Description<span style="color:red;">*</span></label>
		<textarea name="description" maxlength="250" class="form-control mb-3" rows="2" required><?=$recipe['description'];?></textarea>

		<label for="prep" class="form-label">Prep Time (in minutes)<span style="color:red;">*</span></label>
		<input type="number" min="0" max="1000" name="prep" value="<?=$recipe['prep_time'];?>" class="form-control mb-3" required>

		<label for="cook" class="form-label">Cook Time (in minutes)<span style="color:red;">*</span></label>
		<input type="number" min="0" max="1000" name="cook" value="<?=$recipe['cook_time'];?>" class="form-control mb-3" required>

		<label for="calories" class="form-label">Calories</label>
		<input type="number" min="0" max="5000" name="calories" value="<?=$recipe['calories'];?>" class="form-control mb-3">

		<label for="yield" class="form-label">Yield<span style="color:red;">*</span></label>
		<input type="number" min="0" max="100" name="yield" value="<?=$recipe['yield'];?>" class="form-control mb-3" required>

		<label for="publish" class="form-label">Publish Date<span style="color:red;">*</span></label>
		<input type="date" name="publish" class="form-control mb-3" value="<?=$recipe['publish_date'];?>" required>

		<label for="category[]" class="form-label">Category</label>
		<select name="category[]" class="form-control mb-3" multiple>
			<option
			<?php if (in_array('breakfast', $categories)) { ?>
			selected
			<?php } ?>
			value="breakfast">Breakfast</option>
			<option
			<?php if (in_array('entree', $categories)) { ?>
			selected
			<?php } ?>
			value="entree">Entree</option>
			<option
			<?php if (in_array('dessert', $categories)) { ?>
			selected
			<?php } ?>
			value="dessert">Dessert</option>
			<option
			<?php if (in_array('appetizer', $categories)) { ?>
			selected
			<?php } ?>
			value="appetizer">Appetizer</option>
			<option
			<?php if (in_array('drink', $categories)) { ?>
			selected
			<?php } ?>
			value="drink">Drink</option>
			<option
			<?php if (in_array('snack', $categories)) { ?>
			selected
			<?php } ?>
			value="snack">Snack</option>
		</select>

		<label for="cuisine" class="form-label">Cuisine</label>
		<input type="text" name="cuisine" value="<?=$recipe['cuisine'];?>" maxlength="100" class="form-control mb-3">

		<label for="keywords" class="form-label">Keywords</label>
		<textarea name="keywords" maxlength="500" class="form-control mb-3" rows="2"><?=$recipe['keywords'];?></textarea>

		<label for="content" class="form-label">Recipe Content<span style="color:red;">*</span></label>
		<textarea name="content" id="editor" class="form-control mb-3">
		<?=$recipe['content'];?>
		</textarea>

		<div class="form-label mt-3">Ingredients</div>
		<label hidden for="ingredients-measure[]">Ingredient Measurement</label>
		<label hidden for="ingredients-ingredients[]">Ingredient</label>
		<label hidden for="ingredients-notes[]">Ingredient Notes</label>
		<div id="ingredient-list" class="mb-3">

		<?php if (count($ingredients) === 0) { ?>

			<div class="input-group mb-2">
				<input hidden name="ingredients-ids[]">
				<input type="text" name="ingredients-measures[]" class="form-control" placeholder="Measure*" style="max-width:150px!important" required>
				<input type="text" name="ingredients-ingredients[]" class="form-control" placeholder="Ingredient*" required>
				<input type="text" name="ingredients-notes[]" class="form-control notes" placeholder="Notes">
				<select name="ingredients-optional[]" class="form-select" style="max-width:100px!important">
					<option selected value="false">Req</option>
					<option value="true">Opt</option>
				</select>
				<span onclick="addField(this, 'ingredient')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>
			</div>

		<?php } else {
			foreach($ingredients as $key=>$ingredient) { ?>
				<div class="input-group mb-2">
					<input hidden name="ingredients-ids[]" value="<?=$ingredient['id'];?>">
					<input type="text" name="ingredients-measures[]" value="<?=$ingredient['measure'];?>" class="form-control" placeholder="Measure*" style="max-width:150px!important" required>
					<input type="text" name="ingredients-ingredients[]" value="<?=$ingredient['ingredient'];?>" class="form-control" placeholder="Ingredient*" required>
					<input type="text" name="ingredients-notes[]" value="<?=$ingredient['note'];?>" class="form-control notes" placeholder="Notes">
					<select name="ingredients-optional[]" class="form-select" style="max-width:100px!important">

						<option

						<?php if (!$ingredient['optional']) { ?>
						selected
						<?php } ?>

						value="false">Req</option>

						<option

						<?php if ($ingredient['optional']) { ?>
						selected
						<?php } ?>

						value="true">Opt</option>
					</select>
					<span onclick="addField(this, 'ingredient')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>

					<?php if (count($ingredients) !== 1) { ?>
						<span onclick="removeField(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-minus"></i></span>
						<?php if ($key !== 0) { ?>
						<span onclick="moveFieldUp(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-arrow-up"></i></span>
						<?php
						}
						if($key !== (count($ingredients) - 1)) {
						?>
						<span onclick="moveFieldDown(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-arrow-down"></i></span>
						<?php
						}
					}
					?>

				</div>
			<?php
			}
		} ?>

		</div>

		<div class="form-label">Directions</div>
		<label hidden for="directions-name[]">Direction Name</label>
		<label hidden for="directions-text[]">Direction</label>
		<label hidden for="directions-notes[]">Direction Note</label>
		<div id="directions-list" class="mb-3">

		<?php
		if (count($directions) === 0) { ?>

			<div class="input-group mb-2">
				<input hidden name="directions-id[]">
				<textarea name="directions-name[]" class="form-control" placeholder="Name*" rows="2" required></textarea>
				<textarea name="directions-text[]" maxlength="500" class="form-control" rows="2" placeholder="Direction*" required></textarea>
				<textarea type="text" name="directions-notes[]" class="form-control notes" rows="2" placeholder="Notes"></textarea>
				<input type="file" name="directions-image[]" accept="image/png, image/jpeg" class="form-control" style="max-width:270px;">
				<span onclick="addField(this, 'direction')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>
			</div>

		<?php } else {
			foreach ($directions as $key=>$direction) { ?>
				<div class="input-group mb-2">
					<input hidden name="directions-id[]" value="<?=$direction['id'];?>">
					<textarea name="directions-name[]" class="form-control" placeholder="Name*" rows="2" required><?=$direction['name'];?></textarea>
					<textarea name="directions-text[]" maxlength="500" class="form-control" rows="2" placeholder="Direction*" required><?=$direction['text'];?></textarea>
					<textarea type="text" name="directions-notes[]" class="form-control notes" rows="2" placeholder="Notes"><?=$direction['note'];?></textarea>
					<input type="file" name="directions-image[]" value="<?=$direction['image'];?>" accept="image/png, image/jpeg" class="form-control" style="max-width:270px;">
					<span onclick="addField(this, 'direction')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>

					<?php if (count($directions) !== 1) { ?>
						<span onclick="removeField(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-minus"></i></span>
						<?php if ($key !== 0) { ?>
						<span onclick="moveFieldUp(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-arrow-up"></i></span>
						<?php
						}
						if($key !== (count($directions) - 1)) {
						?>
						<span onclick="moveFieldDown(this)" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-arrow-down"></i></span>
						<?php
						}
					}
					?>

				</div>
			<?php }
		} ?>
		</div>

		<label for="image" class="form-label">Image<span style="color:red;">*</span></label>
		<div class="input-group mb-3">
			<div class="input-group-text bg-light text-primary"><i class="fa-solid fa-image"></i></div>
			<input type="file" name="image" accept="image/png, image/jpeg" class="form-control">
		</div>

		<div class="form-check form-switch mb-3">
			<input class="form-check-input" type="checkbox" role="switch" name="active"
			<?php if($recipe['active']) { ?>
			checked
			<?php } ?>
			>
			<label class="form-check-label" for="active">Active</label>
		</div>

		<input type="submit" value="Submit" class="btn btn-primary mb-5">
	</form>
</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
