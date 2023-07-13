<?php
$page = [
	'title' => 'Log In to Spoonful Recipes',
	'description' => 'Use this page to log in to your Spoonful Recipes account',
	'canonical' => 'https://www.spoonfulrecipes.com/login'
];

$f3->set('page', $page);
echo $view->render('inc/head.php', null, compact('f3', 'view', 'page'));
echo $view->render('inc/header.php', null, compact('f3', 'view', 'page'));
	?>

<div class="my-5">

<?php
if(isset($name)) {
	?>
	<div class="alert alert-primary" role="alert">
	Logged in as <?=$name;?>
	<form action="logout">
		<input type="submit" value="Logout">
	</form>
	</div>
	<?php
} else {

	if (isset($login_valid) && $login_valid === false) {
		?>
		<div class="alert alert-danger" role="alert">
		Login Information Incorrect
		</div>
		<?php
	}
	?>

<form method="post" class="my-5">
	<label for="username">Username</label>
	<input name="username" id="username" type="username" required>
	<label for="password">Password</label>
	<input name="password" id="password" type="password" required>
<?php if (isset($_GET['from'])) { ?>
	<input hidden value="<?=$_GET['from'];?>" name="from">
<?php } else { ?>
	<input hidden value="login" name="from">
<?php } ?>
	<input type="submit" value="Login">
</form>

<?php
}
?>

</div>

<?php
echo $view->render('inc/footer.php', null, compact('f3', 'view', 'page'));
?>
