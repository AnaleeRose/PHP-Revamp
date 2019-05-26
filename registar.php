<?php
$error = '';
require_once './includes/connection.php';
$loginPage = 'yep';

if (isset($_POST['loginBtn'])) {
	session_start();
        ob_start();
	$adminUsername = $_POST['username'];
	$adminPassword = $_POST['password'];
	$_SESSION['username'] = $_POST['username'];
}
include './includes/title.php';
require_once './includes/connection.php';
require_once './includes/logout.php';

// create database connection
$conn = dbConnect('admin');
$sql = "SELECT id FROM admin WHERE Username = '$adminUsername' and Password = '$adminPassword'";
// $result = $conn->query
// if (!$result) {
//     $error = $conn->error;
// }




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="imagine, dragons, imagine dragons, dan reynolds, daniel wayne sermon, daniel platzman, ben mckee">
  	<meta name="keywords" content="library, mircroformat, microdata">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin <?php if (isset($title) && $title <> 'Admin2') { echo " | $title";} else {echo " | Login";} ?></title>
	<link rel="icon" type="image/ico" href="images/logoring_.png">

<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">

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
	    <section>
	    <h1><i class="fas fa-users-cog"></i> Admin</h1>
	<?php if (!isset($_SESSION['name'])) { ?>
	    <form  method="post" action="" name="login" id="login">
	    	<p class="col-12 col-md-8 row">
		    	<label for="username">Username: </label>
		    	<input type="text" name="username" id="username">
	    	</p>
			<p class="col-12 col-md-8 row">
		    	<label for="pwd">Password: </label>
		    	<input type="text" name="pwd" id="pwd">
		    </p>

		    <p class="col-12 col-md-8 row">
		    	<label for="pwdC">Confirm Password: </label>
		    	<input type="text" name="pwdC" id="pwdC">
		    </p>

			<p class="col-12 col-md-8 row">
		    	<label for="email">Email: </label>
		    	<input type="text" name="email" id="email">
			</p>
	    	<input type="submit" name="loginBtn" id="loginBtn" value="login" class="d-block btn btn-outline-info my-3">
	    </form>
	<?php } else { ?>
			<h3>Welcome back! You will be rerouted to the main control page shortly...</h3>
	<?php } ?>

	    </section>
	}
	</div>

	<script>
		var allLabels = document.body.querySelectorAll("label");
		var maxL = allLabels.length;


		var allTextInputs = document.body.querySelectorAll('input[type="text"]');
		var maxTI = allTextInputs.length;


		function labelClasses() {
				var i = 0;
			do {
				let label = allLabels[i];
				label.classList.add("col-12", "col-md-4" )
				i++;

			} while (i < maxL)
		}

		function inputClasses() {
				var i = 0;
			do {
				let input = allTextInputs[i];
				input.classList.add("col-12", "col-md-8");
				i++;

			} while (i < maxTI)
		}

		labelClasses();
		inputClasses();

	</script>
</body>
</html>


