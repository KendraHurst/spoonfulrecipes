<?php
$page = [
	'title' => 'Add a new recipe to Frugal Spoonful',
	'description' => 'Fill out the form to add a new recipe',
	'canonical' => 'https://www.frugalspoonful.com'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
?>
<?php
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
	?>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://kit.fontawesome.com/d6ec043418.js" crossorigin="anonymous"></script>
<script src="js/new_recipe.js"></script>
<style>
	#directions-list .btn {
		line-height: 48px;
	}
</style>

<div style="height: 100px;">
</div>

<div class="container">
	<form action="add-recipe" method="post" id="new-recipe">

		<label for="name" class="form-label">Name<span style="color:red;">*</span></label>
		<input type="text" name="name" maxlength="100" class="form-control mb-3" required>

		<label for="author" class="form-label">Author</label>
		<input type="text" name="author" class="form-control mb-3" value="<?=$author;?>" disabled>

		<label for="title" class="form-label">Title<span style="color:red;">*</span></label>
		<input type="text" name="title" maxlength="150" class="form-control mb-3" required>

		<label for="description" class="form-label">Description<span style="color:red;">*</span></label>
		<textarea name="description" maxlength="250" class="form-control mb-3" rows="2" required></textarea>

		<label for="prep" class="form-label">Prep Time (in minutes)<span style="color:red;">*</span></label>
		<input type="number" min="0" max="1000" name="prep" class="form-control mb-3" required>

		<label for="cook" class="form-label">Cook Time (in minutes)<span style="color:red;">*</span></label>
		<input type="number" min="0" max="1000" name="cook" class="form-control mb-3" required>

		<label for="calories" class="form-label">Calories</label>
		<input type="number" min="0" max="5000" name="calories" class="form-control mb-3">

		<label for="yield" class="form-label">Yield<span style="color:red;">*</span></label>
		<input type="number" min="0" max="100" name="yield" class="form-control mb-3" required>

		<label for="publish" class="form-label">Publish Date<span style="color:red;">*</span></label>
		<input type="date" name="publish" class="form-control mb-3" value="<?=date('Y-m-d');?>" required>

		<label for="category" class="form-label">Category</label>
		<select name="category" class="form-control mb-3" multiple>
			<option value="breakfast">Breakfast</option>
			<option value="entree">Entree</option>
			<option value="dessert">Dessert</option>
			<option value="appetizer">Appetizer</option>
			<option value="drink">Drink</option>
			<option value="snack">Snack</option>
		</select>

		<label for="cuisine" class="form-label">Cuisine</label>
		<input type="text" name="cuisine" maxlength="100" class="form-control mb-3">

		<label for="keywords" class="form-label">Keywords</label>
		<textarea name="keywords" maxlength="500" class="form-control mb-3" rows="2"></textarea>

		<div class="form-label">Recipe Content<span style="color:red;">*</span></div>
		<input type="text" name="content" hidden>
		<div id="editor" class="mb-3"></div>

		<div class="form-label mt-3">Ingredients</div>
		<label hidden for="ingredients-measure[]">Ingredient Measurement</label>
		<label hidden for="ingredients-ingredients[]">Ingredient</label>
		<label hidden for="ingredients-notes[]">Ingredient Notes</label>
		<div id="ingredient-list" class="mb-3">
			<div class="input-group mb-2">
				<input type="text" name="ingredients-measures[]" class="form-control" placeholder="Measure*" required>
				<input type="text" name="ingredients-ingredients[]" class="form-control" placeholder="Ingredient*" required>
				<input type="text" name="ingredients-notes[]" class="form-control notes" placeholder="Notes">
				<span onclick="addField(this, 'ingredient')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>
			</div>
		</div>

		<div class="form-label">Directions</div>
		<label hidden for="directions-name[]">Direction Name</label>
		<label hidden for="directions-text[]">Direction</label>
		<label hidden for="directions-notes[]">Direction Note</label>
		<div id="directions-list" class="mb-3">
			<div class="input-group mb-2">
				<textarea name="directions-name[]" class="form-control" placeholder="Name*" rows="2" required></textarea>
				<textarea name="directions-text[]" maxlength="500" class="form-control" rows="2" placeholder="Direction*" required></textarea>
				<textarea type="text" name="directions-notes[]" class="form-control notes" rows="2" placeholder="Notes"></textarea>
				<span onclick="addField(this, 'direction')" class="btn btn-primary btn-outline-light text-white"><i class="fa-solid fa-plus"></i></span>
			</div>
		</div>

		<input type="submit" value="Submit" class="btn btn-primary">
	</form>
</div>

<script>
</script>

<script>
</script>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
