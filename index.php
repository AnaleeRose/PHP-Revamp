<?php require 'includes/Authenticate/connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="imagine, dragons, imagine dragons, dan reynolds, daniel wayne sermon, daniel platzman, ben mckee">
  	<meta name="keywords" content="library, mircroformat, microdata">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Imagine Dragons</title>
	<link rel="icon" type="image/ico" href="images/logoring_.png">

<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

<!--Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
	<script src="js/jquery.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>

    <?php require './includes/HTML/nav.php'; ?>

	<header id="page-top">
			<h1 class="title text-dark text-center">Imagine Dragons</h1>


	</header>


	<main>
		<blockquote class="blockquote text-dark">
				<footer class="blockquote-footer">
					<cite title="Billboard"><a class="text-dark img_link" href="https://www.billboard.com/articles/columns/chart-beat/7857121/imagine-dragons-billboard-artist-100-number-one">Billboard</a></cite></footer>
		</blockquote>
		 <section id="about">
		 	<div class="card card-body bg-light">
				 <h2 class="text-dark text-center">About</h2>
				 <div class="container-fluid font">
					<p class="about aboutp">Imagine dragons is an alternative rock band that was originally formed in Utah of 2008 and relocated in Las Vegas, Nevada in 2009. From there the band quickly gained fame. After working tirelessly for approximately two years, they released their "full-length debut Night Vision" in 2012.</p>
					<blockquote class="blockquote text-dark">
						<footer class="blockquote-footer">
						<cite title="imaginedragonsmusic"><a class="text-dark img_link" href="https://www.imaginedragonsmusic.com/content/about">Imagine Dragons</a></cite></footer>
					</blockquote>

					<p class=" about aboutp">There are still two original band member, Dan Reynolds and Ben Mckee, while the others left and were replaced with Wayne Sermon, and Daniel Platzman.</p>
					<blockquote class="blockquote text-dark">
						<footer class="blockquote-footer">
						<cite title="imaginedragonsmusic"><a class="text-dark img_link" href="https://www.allmusic.com/artist/imagine-dragons-mn0002040645/biography">All Music</a></cite></footer>
					</blockquote>

				</div> <!-- container-fluid: uses full width -->
			</div> <!-- card -->
		</section> <!-- about -->

    <?php
    require './includes/HTML/members.php';
    require './includes/HTML/albums.php';
    ?>

	</main>


	<footer>
	 <?php require './includes/HTML/contact.php'; ?>
     <?php require './includes/HTML/footer.php'; ?>
	</footer>

</body>
</html>
