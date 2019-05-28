<?php
session_start();
ob_start();
if (!$_SESSION['name']){
    header('Location: http://localhost:81/phprevamp/login.php');
}
include '../includes/HTML/title.php';
require_once '../includes/Authenticate/connection.php';
// create database connection
$conn = dbConnect('admin');
$sql = 'SELECT Name, Email FROM faninfo ORDER BY dateJoined DESC';
$result = $conn->query($sql);
if (!$result) {
    $error = $conn->error;
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="imagine, dragons, imagine dragons, dan reynolds, daniel wayne sermon, daniel platzman, ben mckee">
    <meta name="keywords" content="library, mircroformat, microdata">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin <?php if (isset($title)) { echo " | $title";} ?></title>
    <link rel="icon" type="image/ico" href="images/logoring_.png">

    <!-- Links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="../css/admin.css" rel="stylesheet" type="text/css">

    <!--Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

    <!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body class="container-fluid">
    <section>
 <?php require './../includes/HTML/adminNav.php'; ?>
<h1><i class="fas fa-users-cog"></i> Fans</h1>
<?php if (isset($error)) {
    echo "<p>$error</p>";
} else { ?>
    <h4>Email List</h4>
<table class='table'>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    <?php while($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?= $row['Name']; ?></td>
        <td><?= $row['Email']; ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
<p><a href="http://localhost:81/phprevamp/fans/fans_list.php" class="btn btn-outline-info">Back</a></p>
<script src="../js/limitSongList.js"></script>
</section>
</body>
</html>
<?php
ob_end_flush();
?>
