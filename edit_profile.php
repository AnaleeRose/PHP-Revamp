<?php
session_start();
ob_start();
$loginPage= 'yep';
if (isset($_SESSION['name'])) {
        $name = $_SESSION['name'];
     }
if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
     }
if (isset($_SESSION['ID'])) {
        $ID = $_SESSION['ID'];
     }
use includes\Authenticate\CheckPassword;
$error = '';
$loginPage = 'yep';
$errors = [];
$missing = [];
$miscErrors = [];
$required = ['username', 'pwd', 'pwdC', 'email'];
$expected = ['username', 'pwd', 'pwdC', 'email'];
$pwdOk = false;
$usernameOk = false;
$emailOk = false;
$pwdConfOk = false;
$allOk = false;
$insertedCheck = 'untested';

//required checks
foreach ($_POST as $key => $value) {
    $temp = is_array($value) ? $value : trim($value);
    if (empty($temp) && in_array($key, $required)) {
        $missing[] = $key;
        ${$key} = '';
    } elseif (in_array($key, $expected)) {
        ${$key} = $temp;

    }
}
require './includes/Authenticate/connection.php';
include './includes/HTML/title.php';
require './includes/Authenticate/logout.php';
require './includes/Authenticate/checkPassword.php';

if (isset($_POST['registerBtn'])) {
// check the password strength
	$username = trim($_POST['username']);
	$pwd = trim($_POST['pwd']);
	$pwdC = trim($_POST['pwdC']);
	$email = trim($_POST['email']);

	$checkPwd = new CheckPassword($pwd, 3);
	// $checkPwd->requireMixedCase();
	// $checkPwd->requireNumbers(1);
	$pwdOk = $checkPwd->check();
	if ($pwdOk) {
		// $passCheckResult = ['Password OK'];
	} else {
		$passCheckResult = $checkPwd->getErrors();
	}

// sanitizing the username
	$username = filter_var($username, FILTER_SANITIZE_STRING);

	if ($username === $_POST['username']) {
		$usernameOk = true;
	}

// checking/validating the email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $emailOk = true;
} else {
    $emailOk = false;
}

// checking the conf pass
if (isset($_POST['pwd']) && ($_POST['pwdC'] == $_POST['pwd'])) {
	$pwdConfOk = true;
} else {
	$pwdConfOk = false;
}


//checking if everything passes inspection
if ($pwdOk == true && $usernameOk == true && $emailOk == true && $pwdConfOk == true) {
		$allOk = true;
	}
// sending the info to the DB

if ($allOk) {
		// // add 2 database
	$conn = dbConnect('admin');
	$stmt = $conn->stmt_init();
    // create SQL
    $sql = "UPDATE admin SET Username = ?, Password = SHA(?), Email = ? WHERE AdminID = ?";
    // bind parameters and execute statement
    if ($stmt->prepare($sql)) {
        // bind parameters and execute statement
        $stmt->bind_param('sssi', $username, $pwd, $email, $ID);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $insertedCheck = 'sent';
        } else {$insertedCheck = 'failed';}
    } else {
	echo "I can't seem to reach the database... Please check back later!";
	}
}
}



// create database connection
$conn = dbConnect('admin');
// $sql = "SELECT id FROM admin WHERE Username = '$adminUsername' and Password = '$adminPassword'";
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
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/admin.css">

<!--Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
	<script src="js/applyingClasses.js" async></script>
<!-- 	<script src="js/jquery.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script> -->

</head>
<body class="container-fluid">
	<div class="col-12 col-md-10 offset-md-1">
	    <?php //require './includes/HTML/adminNav.php'; ?>
	    <section>
	    	<?php
	    	// tester2 tester2A
	    	if (isset($_POST['registerBtn'])) {
	    	switch ($insertedCheck) {
	    		case 'sent':
	    		header('Location:http://localhost:81/phprevamp/profile.php');
	            break;

	    		case 'failed':
	    		echo "<h1>Woops...</h1><p>The database seems to be down right now, but we'll have it back up in a bit!";
	            break;

				}
			} ?>


	    <h1><i class="fas fa-users-cog"></i><?php if (isset($title) && $title <> 'Admin2') { echo " $title";} else {echo " | Login";} ?></h1>
	    <?php
	    if (($missing || $errors ||isset($passCheckResult) || $usernameOk || $pwdConfOk) && $allOk != true)
	    	{ ?>
	        <p class="warning">Please fix the item(s) indicated</p>

	    <?php } ?>
	    <?php
	    if (isset($passCheckResult)) {
	    	echo '<ul class="warning errorUL">';
	    	foreach ($passCheckResult as $item) {
	    		echo "<li>$item</li>";
	    	}
	    	echo '</ul>';
	    }

	    if (isset($result)) {
	        echo '<ul class="warning errorUL">';
	        foreach ($result as $message) {
	            echo "<li class=\"errorEffect\">$message</li>";
	        }
	        echo '</ul>';
	    }
	    if (isset($missing)) {
	        echo '<ul class="warning errorUL">';
	            foreach ($missing as $fixme) {
	                switch ($fixme) {
	                    case 'username':
	                        echo "<li>Missing: Username</li>";
	                        break;
	                    case 'pwd':
	                        echo "<li>Missing: Password</li>";
	                        break;
	                    case 'pwdC':
	                        echo "<li>Missing: Password Confirmation</li>";
	                    case 'email':
	                        echo "<li>Missing: Email</li>";
	                    break;
	                }
	            }
	        echo '</ul>';
	    }

	    if (isset($_POST['pwd']) && !$pwdConfOk) {
	    	echo '<small class="warning registerSmallE">The passwords do not match.</small>';
	    }

    ?>

	    <form  method="post" action="" name="register" id="register" class="">
	    	<p class="formP">
		    	<label for="username">Username: </label>
		    	<input type="text" name="username" id="username" value="<?= $name?>">
	    	</p>
			<p class="formP">
		    	<label for="pwd">Password: </label>
		    	<input type="text" name="pwd" id="pwd">
		    	<small class="text-info registerSmall">The password must have no spaces, be at least 8 characters long, and have at least one of each of the following: an uppercase letter, a lowercase letter, and a number.</small>
		    </p>

		    <p class="formP">
		    	<label for="pwdC">Confirm Password: </label>
		    	<input type="text" name="pwdC" id="pwdC">
			</p>

			<p class="formP">
		    	<label for="email">Email: </label>
		    	<input type="text" name="email" id="email" value="<?= $email?>">
			</p>
	    	<input type="submit" name="registerBtn" id="registerBtn" value="Edit Account" class="btn btn-outline-info my-3">
	    	<a href="profile.php" class="btn btn-outline-danger my-3">Go Back</a>
	    </form>
	    </section>
	</div>
<script>
	var ulExists = document.body.querySelector(".errorUL");
	var allSmalls = document.body.querySelector("small");
	// if (ulExists) {
	// 	allSmalls.classList.add("hidden");
	// } else {
	// 	console.log('it does NOT exist');
	// }
</script>
</body>
</html>


