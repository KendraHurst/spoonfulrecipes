<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$page['description'];?>">
	<title><?=$page['title'];?></title>

<?php if (isset($page['canonical'])) { ?>
	<link rel="canonical" href="<?=$page['canonical'] ?: "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
<?php } elseif(isset($page['noindex']) && $page['noindex']) { ?>

	<meta name="robots" content="noindex">

<?php } ?>

	<!--stylesheets-->
	<link rel="stylesheet" href="/css/main.css">
	<link rel="stylesheet" href="/css/custom.css">
	<link rel="shortcut icon" type="image/png" href="<?=$f3->get('imgurl');?>logos/favicon.png"/>

	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6117958085618253"
		 crossorigin="anonymous"></script>

	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-7LLM0K0V95"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-7LLM0K0V95');
	</script>

</head>
<body class="text-gray-900 mont antialiased">
<div class="page-wrapper">
