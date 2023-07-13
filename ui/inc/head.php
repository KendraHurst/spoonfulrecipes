<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$page['description'];?>">
	<title><?=$page['title'];?></title>

<?php if (isset($page['canonical'])) { ?>
	<link rel="canonical" href="<?=$page['canonical'] ?: "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
<?php } ?>

<?php if(isset($page['noindex']) && $page['noindex']) { ?>

	<meta name="robots" content="noindex">

<?php } else { ?>
	<!--Analytics tag here-->
<?php } ?>

	<!--stylesheets-->
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/custom.css">
	<link rel="shortcut icon" type="image/png" href="/images/logos/favicon.png"/>

</head>
<body class="text-gray-900 mont antialiased">
<div class="page-wrapper">
