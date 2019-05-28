<?php
$error = '';
require_once './includes/Authenticate/connection.php';
$loginPage = 'yep';

if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
    header('Location:http://localhost:81/phprevamp/profile.php');
}

if (isset($_POST['loginBtn'])) {
	session_start();
        ob_start();
	$username = $_POST['username'];
	$adminUsername = filter_var($username, FILTER_SANITIZE_STRING);
	$adminPassword = $_POST['password'];
}
include './includes/HTML/title.php';
require_once './includes/Authenticate/logout.php';

// create database connection
$conn = dbConnect('admin');
if (isset($_POST['loginBtn'])) {
	$stmt = $conn->stmt_init();
	$sql = "SELECT AdminID, Username, Password, Email FROM admin WHERE Username = '$adminUsername' AND Password = SHA1('$adminPassword')";
	 if ($stmt->prepare($sql)) {
        // bind parameters and execute statement
        $stmt->execute();
        $stmt->bind_result($ID, $usernameDB, $pwdDB, $emailDB);
        $stmt->fetch();
        if (isset($pwdDB)) {
            $_SESSION['name'] = $usernameDB;
            $_SESSION['email'] = $emailDB;
        	$_SESSION['ID'] = $ID;
            echo $_SESSION['name'];
            echo $_SESSION['email'];
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

	    <?php require './includes/HTML/adminNav.php'; ?>
	    <section>
	    <h1><i class="fas fa-users-cog"></i> Admin</h1>
	<?php if (!isset($_SESSION['name'])) { ?>
	    <form  method="post" action="" name="login" id="login">
	    	<label for="username" class="col-12 col-md-2">Username: </label>
	    	<input type="text" name="username" id="username" class="col-10 col-md-8 offset-1 offset-md-0">

	    	<label for="password" class="col-12 col-md-2">Password: </label>
	    	<input type="text" name="password" id="password" class="col-10 col-md-8 offset-1 offset-md-0">

	    	<input type="submit" name="loginBtn" id="loginBtn" value="login" class="d-block btn btn-outline-info my-3">
	    </form>
	<?php } else { ?>
            <?php if (isset($_SESSION['email'])) {
        header('Location:http://localhost:81/phprevamp/profile.php');
            }

            ?>
            <h3>Welcome back! You will be rerouted to the main control page shortly...</h3>
	<?php } ?>

	    </section>
	</div>
</body>
</html>

</body>
</html>
<?php
ob_end_flush();
?>


