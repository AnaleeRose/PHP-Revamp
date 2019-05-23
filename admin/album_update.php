<?php
include '../includes/title.php';
require_once '../includes/connection.php';
// intialize flags
$OK = false;
$done = false;
// create db connection
$conn = dbConnect('admin');
// intialize statment
$stmt = $conn->stmt_init();
// get details of selected record
if (isset($_GET['article_id']) && !$_POST) {
    // prepare SQL query
    $sql = 'SELECT AlbumID, AlbumName) FROM Albums WHERE AlbumID = ?';
    if ($stmt->prepare($sql)) {
        //bind the query parameter
        $stmt->bind_param('i', $_GET['article_id']);
        // execute the query, and fetch the result
        $OK = $stmt->execute();
        // bind the results to the variables
        $stmt->bind_result($article_id, $title, $article);
        $stmt->fetch();
    }
}
// if form has been submitted, update record
if (isset($_POST['update'])) {
    // prepare update query
    $sql = 'UPDATE Albums  SET AlbumName = ? WHERE AlbumID = ?';
    if ($stmt->prepare($sql)) {
        $stmt->bind_param('ssi', $_POST['title'], $_POST['article'], $_POST['AlbumID']);
        $done = $stmt->execute();
    }
}
// redirect if $_GET['article_id'] not defined
if ($done || !isset($_GET['article_id'])) {
    header('Location: http://localhost/phprevamp/admin.php');
    exit;
}
// get error message if query fails
if (isset($stmt) && !$OK && !$done) {
    $error = $stmt->error;
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
    <link href="../styles/admin.css" rel="stylesheet" type="text/css">

<!--Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body class="container-fluid">
<h1>Insert New Blog Entry</h1>
<?php if (isset($error)) {
    echo "<p class='warning'>Error: $error</p>";
}
if ($article_id == 0) {?>
    <p class="warning">Invalid Request: record does not exist.</p>
<?php } else { ?>
<form method="post" action="">
    <p>
        <label for="title">Title:</label>
        <input name="title" type="text" id="title" value="<?= htmlentities($title); ?>">
    </p>
    <p>
        <label for="article">Article:</label>
        <textarea name="article" id="article"><?= htmlentities($article); ?></textarea>
    </p>
    <p>
        <input name="article_id" type="hidden" value="<?= htmlentities($article_id); ?>">
        <input type="submit" name="update" value="Update Entry" id="update">
    </p>
</form>
<?php } ?>
</body>
</html>
