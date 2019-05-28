<?php
include '../includes/HTML/title.php';
require_once '../includes/Authenticate/connection.php';
$conn = dbConnect('admin');
// initialize flags
$OK = false;
$deleted = false;
$error = [];
// initialize statement
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['AlbumID'])) {
    $AlbumID = $_GET['AlbumID'];
    // prepare SQL query
    $sql = "SELECT AlbumID, AlbumName, dateCreated FROM albums WHERE AlbumID = $AlbumID";
    $selectCurrentAlbum = $conn->query($sql);
    if ($selectCurrentAlbum) {
        while ($row = $selectCurrentAlbum->fetch_array()) {
            $dbAlbumID = $row['AlbumID'];
            $albumName = str_replace('.', ' ', $row['AlbumName']);
            $dateCreated = $row['dateCreated'];
        }
    } else {
        $error[] = "That record does not exist.";
    }
}


// if confirm deletion button has been clicked, delete record
if (isset($_POST['delete'])) {
    $sql = "DELETE FROM songs WHERE AlbumID = $AlbumID";
    $deleteSongs = $conn->query($sql);
    if ($deleteSongs) {
        $sqlDelete = "DELETE FROM albums WHERE AlbumID = $AlbumID";
        $deleteAlbum = $conn->query($sqlDelete);
        if ($deleteAlbum) {
            $deleted = true;
            $sqlCheck = "SELECT * FROM albums WHERE AlbumID = $AlbumID";
            $runSqlCheck = $conn->query($sqlCheck);
            if ($runSqlCheck) {
                echo "waddup";
            }
        }
    } else {
        $error[] = "The database cannot currently be reached...";
    }
}
// redirect the page if deletion is successful,
// cancel button clicked, or $_GET['AlbumID'] not defined
// if ($deleted || isset($_POST['cancel_delete']) ||
if (!isset($_GET['AlbumID']))  {
    header('Location: http://localhost:81/phprevamp/login.php');
    exit;
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
<?php
require './../includes/HTML/adminNav.php';
if (!empty($error)) {
print_r($error);
}
?>
<section>
<h1 class="pb-3"><i class="fas fa-users-cog"></i> Albums | Delete Entry</h1>
<?php if ($deleted) {
    header('Location:http://localhost:81/phprevamp/admin/album_list.php');;
} else {

?>
<?php
if (isset($error)  && !empty($error)) {
    echo "<p class='warning'>Error: $error</p>";
}
if($AlbumID == 0) { ?>
    <p class="warning">Hm... that album doesn't seem to exist.</p>
<?php } else { ?>
    <p><?php if (isset($albumName)){ ?>
    <p class="warning fullSize">Please confirm that you want to delete this album.</p>
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Date created</th>
        </tr>
        <tr>
    <?php
        echo '<td>'.htmlentities($albumName).'</td>';
        echo '<td>'. $dateCreated.'</td>';
    ?>
        </tr>
    </table>
<form method="post" action="">
    <p>
        <?php if(isset($AlbumID) && $AlbumID > 0) { ?>
            <input type="submit" name="delete" value="Confirm Deletion" class="btn btn-outline-danger mt-2 mr-2">
        <?php } ?>
        <a href="http://localhost:81/phprevamp/admin/album_list.php" id="cancel_delete" class="btn btn-outline-info mt-2">Cancel</a>
    </p>
</form>
<?php
        } // <p><?php if (isset($albumName)){
    }
} ?>
</section>
</body>
</html>
