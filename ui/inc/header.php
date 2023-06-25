<nav class="navbar navbar-expand-md bg-light fixed-top container-fluid d-print-none">
	<a class="navbar-brand fs-2 fw-bold text-primary" href="/">
		<img src="/images/logos/logo.png" alt="Spoonful Logo" height="50px" width="50px" class="d-inline-block align-text-center ms-0 me-2 my-1">
		Frugal Spoonful
	</a>

	<button class="navbar-toggler border-0 me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse justify-content-end me-3" id="navbarNav">
		<ul class="navbar-nav align-items-center fs-4">
			<li class="nav-item mx-2 pb-1">
				<a
				<?php if ($_SERVER['REQUEST_URI'] === "/") { ?>
				class="nav-link fw-semibold active" aria-current="page"
				<?php } else { ?>
				class="nav-link"
				<?php } ?>
				href="/">Home</a>
			</li>
			<li class="nav-item mx-2 pb-1">
				<a
				<?php if ($_SERVER['REQUEST_URI'] === "/about") { ?>
				class="nav-link fw-semibold active" aria-current="page"
				<?php } else { ?>
				class="nav-link"
				<?php } ?>
				href="/about">About</a>
			</li>
			<li class="nav-item mx-2 pb-1">
				<a
				<?php if (strpos($_SERVER['REQUEST_URI'], "/recipes") === 0) { ?>
				class="nav-link fw-semibold active" aria-current="page"
				<?php } else { ?>
				class="nav-link"
				<?php } ?>
				href="/recipes">Recipes</a>
			</li>
			<li class="nav-item mx-2 pb-1">
				<input class="form-control me-2 rounded-pill" id="search-bar" type="search" placeholder="Search" aria-label="Search">
			</li>
		</ul>
	</div>
</nav>
