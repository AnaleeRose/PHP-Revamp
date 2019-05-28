<?php
session_start();
ob_start();
if (!$_SESSION['name']) {
    header('Location: http://localhost:81/phprevamp/login.php');
}
$yep = false;
$success= false;
$errors = [];
$missing = [];
$required = ['name', 'cover', 'song1'];
$expected = ['name', 'cover', 'song1', 'song2', 'song3', 'song4', 'song5', 'song6', 'song7', 'song8', 'song9', 'song10', 'song11', 'song12', 'song13', 'song14', 'song15', 'song16', 'song17', 'song18', 'song19', 'song20'];
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
if (isset($_POST['insertBtn'])) {
    $file_size =$_FILES['cover']['size'];
    if ($file_size <= 0) {
        $temp = 'cover';
        $missing[] = $temp;
}
}
$songlist = [];
require_once '../includes/Authenticate/connection.php';
require_once 'includes/upload.php';
use includes\Upload;
if (isset($_POST['insertBtn']) && !$errors && !$missing) {
    $destination = '../images/user-images/';
    $max = 5000000;
    require_once 'includes/upload.php';
    $albumName = $_POST['name'];
    $albumName = preg_replace('/[^a-zA-Z0-9-]/', '', $albumName);
    $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
    if (!empty($_FILES['cover'])) {
        try {
            $loader = new Upload($destination, $albumName, $yep);
            $loader->setMaxSize($max);
            $loader->upload();
            // $loader->checkName($_FIlES['cover']);
            $result = $loader->getMessages();
            $result = $loader->getMessages();
            $answer = $loader->yep;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    if ($answer) {
        $conn = dbConnect('admin');
        // inserts the album name and extension into the db
        $sql = "INSERT INTO albums (AlbumName, imgType) VALUES ('$albumName', '$extension')";
        $insertAlbum = $conn->query($sql);
        // if successful, it will grab the id and then insert the songs
        if ($insertAlbum) {
            $sql = "SELECT AlbumID FROM albums ORDER BY dateCreated DESC LIMIT 1";
            $newAlbumID = $conn->query($sql);
            foreach ($newAlbumID->fetch_assoc() as $ID) {
                 $currentAlbumID = $ID;
            }
            $success = true;
        } else {
            $errors = "The database cannot currently be reached...";
        }
    }

}
// song/img name
$i = 1;
if (isset($_POST['insertBtn']) && isset($currentAlbumID)) {

    // clears songs of anything except the following and adds them to the songlist array for later
    while ($i <= 20) {
        $song = 'song' . $i;
        if (!empty($_POST["$song"])) {
            $songName = preg_replace('/[^a-zA-Z0-9\- ]/', '', $_POST["$song"]);
            $songName = str_replace(' ', ".", $songName);
            if ($songName) {array_push($songlist, $songName);}

            if (!in_array($songName, $songlist)) {
                $error .= "Could not upload $songName.";
            }
        }
        $i++;
    };
    // sends the songs to the db
    foreach ($songlist as $key => $value) {
        $sql = "INSERT INTO Songs (AlbumID, Name) VALUES ('$currentAlbumID', '$value')";
        $newSong = $conn->query($sql);
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
    <link href="http://localhost:81/phprevamp/css/admin.css" rel="stylesheet" type="text/css">

        <!--Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

        <!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>var page = 'insert'</script>
    <script src="../js/limitSongList.js" defer></script>
    <script src="../js/successDiv.js" defer></script>
</head>

<body class="container" onload="errorToSuccess();">
<?php
include '../includes/HTML/title.php';
include '../includes/HTML/adminNav.php';
?>
<section>

<h1 class="pb-3"><i class="fas fa-users-cog"></i> Albums | New Album</h1>
<?php
if (isset($success)) {
        if ($success)  {
            header('Location:http://localhost:81/phprevamp/admin/album_list.php');
        } else { ?>
    <div id="errors">
    <?php
    if ($missing || $errors) { ?>
        <p class="warning">Please fix the item(s) indicated</p>

    <?php } ?>
    <?php
    if (isset($result)) {
        echo '<ul>';
        foreach ($result as $message) {
            echo "<li class=\"errorEffect\">$message</li>";
        }
        echo '</ul>';
    }
    if (isset($error)) {
        echo "<p class=\"errorEffect\">Error: $error</p>";
    }
    if (isset($missing)) {
        echo '<ul id="errorList">';
            foreach ($missing as $fixme) {
                switch ($fixme) {
                    case 'name':
                        echo "<li class=\"errorEffect\">Missing: Album name</li>";
                        break;
                    case 'song1':
                        echo "<li class=\"errorEffect\">Missing: At least one song</li>";
                        break;
                    case 'cover':
                        echo "<li class=\"errorEffect\">Missing: Album cover</li>";
                        break;
                }
            }
        echo '</ul>';
    }
    ?>

    </div>

<form method="post" actionb="" class="" enctype="multipart/form-data" name="insert" id="insertForm">
    <p class="col-12 col-md-8 row">
        <label for="name" class="col-12 col-sm-3 ">Album Name:

        </label>
        <input name="name" type="text" id="name" class="col-10 col-sm-9 ml-3 ml-sm-0" required>
        <small class="text-info pl-3 smallFont nameSmall">Required</small>
    </p>
    <p class="col-12 col-md-8 row">
        <label for="cover"  class="col-12 col-sm-3">Album Cover:</label>
        <input name="cover" type="file" id="cover" class="col-10 col-sm-9 ml-0 ml-sm-n3" required>
        <small class="text-info pl-3 smallFont coverSmall">Required</small>
    </p>
    <h3 class="pb-3 pl-2 tracks mb-n3">Track List:</h3>
    <small class="text-info pl-3 mb-4 d-inline-block smallFont tSmall">Required: at least one song | Max: 20 Songs</small>
    <small class="text-info mb-4 d-inline-block smallFont"></small>
    <div id="songs" class="col-12 .smallInputs">
        <p class="col-10 row">
            <label for="song1" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song1" type="text" id="song1"  class="col-9 col-md-10 col-xl-11" required>
        </p>
        <p class="col-10 row">
            <label for="song2" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song2" type="text" id="song2" class="col-9 col-md-10 col-xl-11" >
        </p>
        <p class="col-10 row">
            <label for="song3" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song3" type="text" id="song3" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song4" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song4" type="text" id="song4" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song5" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song5" type="text" id="song5" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song6" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song6" type="text" id="song6" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song7" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song7" type="text" id="song7" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song8" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song8" type="text" id="song8" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song9" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song9" type="text" id="song9" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song10" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song10" type="text" id="song10" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song11" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song11" type="text" id="song11" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song12" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song12" type="text" id="song12" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song13" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song13" type="text" id="song13" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song14" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song14" type="text" id="song14" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song15" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song15" type="text" id="song15" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song16" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song16" type="text" id="song16" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song17" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song17" type="text" id="song17" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song18" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song18" type="text" id="song18" class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row hide">
            <label for="song19" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song19" type="text" id="song19" class="col-9 col-md-10 col-xl-11">
        </p>


        <p class="col-10 row hide">
            <label for="song20" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song20" type="text" id="song20" class="col-9 col-md-10 col-xl-11">
        </p>

    </div>

    <p class="col-5 col-md-2">
        <a class="songBtn" id="newSong">+</a>
    </p>

    <p class="">
        <input type="submit" name="insertBtn" value="Insert New Album" id="insert" class="btn btn-outline-info d-inline-block">
        <a href="http://localhost:81/phprevamp/admin/album_list.php" id="cancel_delete" class="btn btn-outline-danger d-inline-block">Cancel</a>
    </p>
</form>
<?php } }
ob_end_flush();
?>
</section>
</body>
</html>
