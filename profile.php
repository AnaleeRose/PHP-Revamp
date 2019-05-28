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
require './includes/Authenticate/logout.php';
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
	    <h1><i class="fas fa-users-cog"></i> Admin <?php if (isset($title)) { echo " | $title";} ?></h1>
<h4>Username: </h4><p><?= $name; ?></p>
<h4>Email: </h4><p><?= $email; ?></p>
    <a id="editProfileBtn" class="btn btn-outline-info text-info" href="http://localhost:81/phprevamp/edit_profile.php">Edit profile</a>
    <a id="logout" class="btn btn-outline-info text-info">Logout</a>
<form method="post" action="" class="hidden" id="trueForm" onclick="alert()">
    <div>
    <p>Are you sure you want to log out?</p>
    <input type="submit" name="logoutBtn" id="logoutBtn" value="Yes" class="btn btn-outline-danger">
    <a href="#" id="noBtn" class="btn btn-outline-info">No</a>
    </div>
</form>

	    </section>
	</div>
    <script type="text/javascript">
        var trueForm = document.body.querySelector('#trueForm');
        var logoutBtn = document.body.querySelector('#logout');
        var noBtn = document.body.querySelector('#noBtn');
        logoutBtn.addEventListener("click", toggleLogout);
        noBtn.addEventListener("click", toggleLogout2);
        function toggleLogout() {
            if (trueForm.classList.contains("hidden")) {
                trueForm.classList.remove("hidden");
                trueForm.classList.add("logoutOverlay");
            } else {
                trueForm.classList.remove("logoutOverlay");
                trueForm.classList.add("hidden");
            }

        }
        function toggleLogout2() {
                trueForm.classList.remove("logoutOverlay");
                trueForm.classList.add("hidden");
        }
    </script>
</body>
</html>
<?php
ob_end_flush();
