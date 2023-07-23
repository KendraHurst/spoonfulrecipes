<?php
use Web;
?>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>https://www.spoonfulrecipes.com</loc>
	</url>
	<url>
		<loc>https://www.spoonfulrecipes.com/about</loc>
	</url>
	<url>
		<loc>https://www.spoonfulrecipes.com/recipes</loc>
	</url>
	<?php
	foreach($recipes as $recipe) { ?>
	<url>
		<loc>https://www.spoonfulrecipes.com/recipes/<?=$recipe['id'];?>/<?=Web::instance()->slug($recipe['name']);?></loc>
	</url>
	<?php
	} ?>
	<url>
		<loc>https://www.spoonfulrecipes.com/privacy</loc>
	</url>
	<url>
		<loc>https://www.spoonfulrecipes.com/terms</loc>
	</url>
</urlset>
