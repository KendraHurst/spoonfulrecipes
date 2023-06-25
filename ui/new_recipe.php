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

<div style="height: 100px;">
</div>

<div class="container">
	<form action="add_recipe" method="post">
		<label for="name" class="form-label">Recipe Name</label>
		<input type="text" name="name" class="form-control mb-2">
		<label for="author" class="form-label">Author</label>
		<input type="text" name="author" class="form-control mb-2" value="<?=$author;?>" disabled>

		<div id="editor" class="mb-3">

		<input type="submit" value="Submit">
		</div>
	</form>
</div>

<script>
const quill = new Quill('#editor', {
  modules: {
    toolbar: [
      ['bold', 'italic'],
      ['link', 'blockquote', 'code-block', 'image'],
      [{ list: 'ordered' }, { list: 'bullet' }]
    ]
  },
  placeholder: 'Content for the recipe page...',
  theme: 'snow'
});

const form = document.querySelector('form');
form.onsubmit = function() {
  // Populate hidden form on submit
  var about = document.querySelector('input[name=content]');
  about.value = JSON.stringify(quill.getContents());

  console.log("Submitted", $(form).serialize(), $(form).serializeArray());

  // No back end to actually submit to!
  alert('Open the console to see the submit data!')
  return false;
};
</script>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
