<?php
include '../includes/title.php';
$songlist = [];
if (isset($_POST['insert']))
{

}

require_once 'includes/upload.php';
use includes\Upload;
if (isset($_POST['insert'])) {
    $destination = '../images/user-images/';
    $max = 5000000;
    require_once 'includes/upload.php';
    $albumName = $_POST['name'];
    $nospaces = str_replace(' ', '-', $albumName);
    $nop1 = str_replace('(', '', $nospaces);
    $nop2 = str_replace(')', '', $nop1);
    $noplus = str_replace('+', '', $nop2);
    $albumName = $noplus;
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    try {
        $loader = new Upload($destination, $albumName);
        $loader->setMaxSize($max);
        $loader->allowAllTypes();
        $loader->upload();
        $result = $loader->getMessages();
    } catch (Exception $e) {
        echo $e->getMessage();
    }


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
    <!-- <link href="../styles/admin.css" rel="stylesheet" type="text/css"> -->

<!--Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<!--     <script src="js/jquery.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
</head>

<body class="container-fluid">
<h1><i class="fas fa-users-cog"></i> Albums | New Entry</h1>
<?php
if (isset($result)) {
    echo '<ul>';
    foreach ($result as $message) {
        echo "<li>$message</li>";
    }
    echo '</ul>';
    echo $imgName;
}
if (isset($error)) {
    echo "<?>Error: $error</p>";
}
?>
<?php
$i = 1;
$k = 1;
if (isset($_POST['insert'])) {
    // user uploaded image
    // loop through all the songs and pick all the names and assign them to an array for later
    while ($i <= 20) {
        $song = 'song' . $i;
        if (!empty($_POST["$song"])) {
            array_push($songlist, $_POST["$song"]);
        }
        $i++;
    }

} ?>

<form method="post" actionb="" class="" enctype="multipart/form-data">
    <p>
        <label for="name">Album Name:</label>
        <input name="name" type="text" id="name">
    </p>
    <p>
        <label for="cover">Album Cover:</label>
        <input name="cover" type="file" id="cover">
    </p>
    <div id="songs">
        <p>
            <label for="song1">Title:</label>
            <input name="song1" type="text" id="song1">
        </p>
        <p>
            <label for="song2">Title:</label>
            <input name="song2" type="text" id="song2">
        </p>
        <p>
            <label for="song3">Title:</label>
            <input name="song3" type="text" id="song3">
        </p>
        <p>
            <label for="song4">Title:</label>
            <input name="song4" type="text" id="song4">
        </p>
    </div>
    <p>
        <button class="btn btn-outline-info" id="newSong">+</button>
    </p>

    <p>
        <input type="submit" name="insert" value="Insert New Entry" id="insert" class="btn btn-outline-info">
    </p>
</form>
    <script src="./test.js"></script>
</body>
</html>
