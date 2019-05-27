<?php
$error = '';
require_once './includes/Authenticate/connection.php';
$loginPage = 'yep';

if (isset($_POST['loginBtn'])) {
	session_start();
        ob_start();
	$username = $_POST['username'];
	$adminUsername = filter_var($username, FILTER_SANITIZE_STRING);
	$adminPassword = $_POST['password'];
	$adminPasswordHash = password_hash($adminPassword, PASSWORD_DEFAULT);
	$_SESSION['username'] = $_POST['username'];
}
include './includes/HTML/title.php';
require_once './includes/Authenticate/logout.php';

// create database connection
$conn = dbConnect('admin');
if (isset($_POST['loginBtn'])) {
	$stmt = $conn->stmt_init();
	$sql = "SELECT Password FROM admin WHERE Username = ?";
	 if ($stmt->prepare($sql)) {
        // bind parameters and execute statement
        $stmt->bind_param('s', $adminUsername);
        $stmt->execute();
        $stmt->bind_result($answer);
        $stmt->fetch();
        if (isset($answer)) {
        	echo $adminPasswordHash;
        	echo $answer;
        	if (password_verify($adminPasswordHash, $answer) || $adminPassword == $answer) {
        		echo "verfied!";
        	}else {echo "nope, not verfied...";}
        	echo "Welcome $adminUsername";
        } else {
        	echo "<p class=\"warning\">That user doesn't exist...";
        }
    }
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
    <title>Admin <?php if (isset($title) && $title <> 'Admin2') { echo " | $title";} else {echo " | Login";} ?></title>
	<link rel="icon" type="image/ico" href="images/logoring_.png">

<!-- Links -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">

<!--Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->

</head>
<body class="container-fluid">
	<div class="col-12 col-md-10 offset-md-1">

	    <?php // require './includes/HTML/adminNav.php'; ?>
	    <section>
	    <h1><i class="fas fa-users-cog"></i> Admin</h1>
	<?php if (!isset($_SESSION['name'])) { ?>
	    <form  method="post" action="" name="login" id="login">
	    	<label for="username">Username: </label>
	    	<input type="text" name="username" id="username">

	    	<label for="password">Password: </label>
	    	<input type="text" name="password" id="password">

	    	<input type="submit" name="loginBtn" id="loginBtn" value="login" class="d-block btn btn-outline-info my-3">
	    </form>
	<?php } else { ?>
			<h3>Welcome back! You will be rerouted to the main control page shortly...</h3>
	<?php } ?>

	    </section>
	</div>
</body>
</html>

</body>
</html>
