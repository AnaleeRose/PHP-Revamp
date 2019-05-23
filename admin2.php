<?php require_once './includes/connection.php';
$loginPage = 'yep';

?>
<?php
include './includes/title.php';
require_once './includes/connection.php';
// create database connection
$conn = dbConnect('admin');
$sql = 'SELECT AlbumName, ImgType FROM Albums';
$stmt = $conn->stmt_init;
$stmt = prepare($sql);
$result = $conn->query($sql);
if (!$result) {
    $error = $conn->error;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="imagine, dragons, imagine dragons, dan reynolds, daniel wayne sermon, daniel platzman, ben mckee">
  	<meta name="keywords" content="library, mircroformat, microdata">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin <?php if (isset($title)) { echo " | $title";} ?></title>
	<link rel="icon" type="image/ico" href="images/logoring_.png">

<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

<!--Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
<!-- 	<script src="js/jquery.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script> -->

</head>
<body class="container-fluid">
	<div class="col-12 col-md-10 offset-md-1">

	    <?php require './includes/adminNav.php'; ?>
	    <h1><i class="fas fa-users-cog"></i> Admin</h1>
	    <?php if (1==1) { ?>
	    <pre><?php

	    	while ($row = $result->fetch_row()) {
	    	    echo $row[0] . '| ' . $row[1] . "\n";
	    	}

	    	 ?></pre>
	    	 <?php   ?>
		<!-- <img src="images/<?php //echo "$name[1] . '.' . $all[2]" ?>"> -->
		<p class="text-danger">If you are unauthorized personal, please leave this section of the site immediately</p>
	<? } else {echo "<h2>Well this is embarrassing...</h2> <p>The database is currently down, please return later!</p>";} ?>
	</div>
</body>
</html>

</body>
</html>
