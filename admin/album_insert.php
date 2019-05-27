<?php
$errors = [];
$missing = [];
$required = ['name', 'song1'];
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
$songlist = [];
// image checking
require_once 'includes/upload.php';
use includes\Upload;
if (isset($_POST['insert']) && !$errors && !$missing) {
    $destination = '../images/user-images/';
    $max = 5000000;
    require_once 'includes/upload.php';
    $albumName = $_POST['name'];
    $albumName = preg_replace('/[^a-zA-Z0-9-]/', '', $albumName);
    $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
    try {
        $loader = new Upload($destination, $albumName);
        $loader->setMaxSize($max);
        $loader->upload();
        // $loader->checkName($file);
        $result = $loader->getMessages();
        // echo $albumName;
        // echo $extension;
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
// song/img name
$i = 1;
if (isset($_POST['insert'])) {
    // clears songs of anything except the following and adds them to the songlist array for later
    while ($i <= 20) {
        $song = 'song' . $i;
        if (!empty($_POST["$song"])) {
            $songName = preg_replace('/[^a-zA-Z0-9\- ]/', '', $_POST["$song"]);
            $songName = str_replace(' ', ".", $songName);
            if ($songName) {array_push($songlist, $songName);}

            if (!in_array($songName, $songlist)) {
                $error .= "Could nfot upload $songName.";
            }
            echo $songName;
        }
        $i++;
    }

}

//sql work
// if (isset($_POST['insert'])) {
//     require '../includes/connection.php';
//     // initialize flag
//     $OK = false;
//     // create database connection
//     $conn = dbConnect('admin');
//     // initialize prepared statement
//     $stmt = $conn->stmt_init();
//     // create SQL
//     $sql = 'INSERT INTO Albums (AlbumName, ImgType) VALUES(?, ?)';
//     // bind parameters and execute statement
//     if ($stmt->prepare($sql)) {
//         // bind parameters and execute statement
//         $stmt->bind_param('ss', $albumName, $extension);
//         $stmt->execute();
//         if ($stmt->affected_rows > 0) {
//             $OK = true;
//         }
//     }
//     // redirect if successful or display error
//         $sql = 'SELECT AlbumID FROM Albums ORDER By dateCreated DESC LIMIT 1';
//         // bind parameters and execute statement
//         if ($stmt->prepare($sql)) {
//             // bind parameters and execute statement
//             $stmt->execute();
//             $stmt->bind_result($albumID);
//             while ($stmt->fetch()) {
//                 foreach ($songlist as $value) {
//                     $sql = "INSERT INTO Songs (AlbumID, Name) VALUES ('$albumID', '$value')";
//                     // bind parameters and execute statement
//                     if ($stmt->prepare($sql)) {
//                         // bind parameters and execute statement
//                         $stmt->execute();
//                         if ($stmt->affected_rows > 0) {
//                             $OK = true;
//                         }
//                     }
//                 }
//             }
//         // header('Location: http://localhost/phpsols/admin/blog_list_mysqli.php');
//         // exit;
//         }

//         if ($OK) {
//             echo ('reroute dis bad boy');
//             // header('Location: http://www.google.com');
//             exit;
//         } else {
//             $error = $stmt->error;
//         }
//     }
// query for an albums tracklist
// SELECT s.Name, a.AlbumName FROM Albums AS a JOIN Songs AS s ON a.AlbumID=s.AlbumID WHERE a.AlbumID = 47;




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
</head>

<body class="container">
<?php
?>
<?php
include '../includes/title.php';
include '../includes/adminNav.php';
?>
<section>
    <?php
    foreach ($songlist as $key => $value) {
        $sql = "INSERT INTO Songs (AlbumID, Name) VALUES ('1', '$value')";
        echo $sql;
    }
    ?>
<h1 class="pb-3"><i class="fas fa-users-cog"></i> Albums | New Entry</h1>
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
                        echo "<li class=\"errorEffect\">Missing: Album Cover</li>";
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
        <input name="name" type="text" id="name" class="col-10 col-sm-9 ml-3 ml-sm-0">
    </p>
    <p class="col-12 col-md-8 row">
        <label for="cover"  class="col-12 col-sm-3">Album Cover:</label>
        <input name="cover" type="file" id="cover" class="col-10 col-sm-9 ml-0 ml-sm-n3">
    </p>
    <h3 class="pb-3 pl-2 tracks">Track List:</h3>
    <div id="songs" class="col-12 .smallInputs">
        <p class="col-10 row">
            <label for="song1" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song1" type="text" id="song1"  class="col-9 col-md-10 col-xl-11">
        </p>
        <p class="col-10 row">
            <label for="song2" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song2" type="text" id="song2" class="col-9 col-md-10 col-xl-11">
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

    <p class="col-6 col-md-2">
        <a class="songBtn" id="newSong">+</a>
    </p>

    <p class="col-6 col-md-3">
        <input type="submit" name="insert" value="Insert New Entry" id="insert" class="btn btn-outline-info">
    </p>
</form>
</section>


</body>
</html>
