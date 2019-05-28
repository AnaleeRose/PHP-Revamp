<?php
use includes\Authenticate\CheckPassword;
session_start();
ob_start();
include '../includes/HTML/title.php';
require_once '../includes/Authenticate/connection.php';
// intialize flags
$OK = false;
$done = false;
$currentAlbumID = $_GET['AlbumID'];
$albumName = 'Unknown';
$updated = false;
$nextStep = false;
$success = false;
// checking to see you didn't delete everything
$errors = [];
$missing = [];
$required = ['name', 'song1'];
$expected = ['name', 'cover', 'song1', 'song2', 'song3', 'song4', 'song5', 'song6', 'song7', 'song8', 'song9', 'song10', 'song11', 'song12', 'song13', 'song14', 'song15', 'song16', 'song17', 'song18', 'song19', 'song20'];
foreach ($_POST as $key => $value) {
    $temp = is_array($value) ? $value : trim($value);
    if (empty($temp) && in_array($key, $required)) {
        $missing[] = $key;
        ${$key} = '';
    } elseif (in_array($key, $expected)) {
        ${$key} = $temp;

    }
}
// create db connection
$conn = dbConnect('admin');
// intialize statment
$stmt = $conn->stmt_init();












// track how many songs there are
$k = 0;
$kcheck = true;
$kCount = 1;


// get details of selected record
if (isset($_GET['AlbumID'])) {
    $cAlbumID = $_GET['AlbumID'];
    // prepare SQL query
    $query = "SELECT a.AlbumID, a.AlbumName, a.ImgType, s.Name FROM Albums AS a JOIN Songs AS s ON a.AlbumID=s.AlbumID WHERE a.AlbumID = $cAlbumID";
    $result = $conn->query($query);
    $i=0;
    if ($result) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $albumID = $row['AlbumID'];
            // echo $albumID;
            $albumName = $row['AlbumName'];
            $albumName = str_replace('.', ' ', $albumName);
            // echo $albumName;
            $prevExtension = $row['ImgType'];
            $songName = $row['Name'];
            $songName = str_replace('.', ' ', $songName);
            // echo $songName;

            $song[$i] = $songName;
            $kCount = (count($song) - 1);
            $i++;
       }
    } else {
        echo "0 results";
    }
    // $conn->close();
    // $stmt = $conn->stmt_init();
    //
    // if ($stmt->prepare($query)) {
    //     //bind the query parameter
    //     $stmt->bind_param('i', $_GET['AlbumID']);
    //     // execute the query, and fetch the result
    //     $OK = $stmt->execute();
    //     // bind the results to the variables
    //     $stmt->bind_result($albumID, $albumName, $songName);
    //     $i = 0;
    //    while ($stmt->fetch()) {
    //         echo $albumID;
    //         $albumName = str_replace('.', ' ', $albumName);
    //         echo $albumName;
    //         $songName = str_replace('.', ' ', $songName);
    //         echo $songName;
    //         $song[$i] = $songName;
    //         $kCount = (count($song) - 1);
    //         $i++;
    //    }

    }


require_once 'includes/upload.php';
use includes\Upload;
if (isset($_POST['update'])) {
    // setup
    $destination = '../images/user-images/';
    $max = 5000000;
    // creates the new album name
    $newAlbumName = $_POST['name'];
    $newAlbumName = str_replace(' ', '.', $_POST['name']);
    $newAlbumName = preg_replace('/[^a-zA-Z0-9-(-)-.-]/', '', $newAlbumName);
    $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
    if (empty($extension)) {
        $extension = $prevExtension;
    }
    // checks the image and name
    try {
        $loader = new Upload($destination, $newAlbumName);
        $loader->setMaxSize($max);
        $loader->upload();
        $loader->checkName($_FILES["cover"]);
        $result = $loader->getMessages();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    //updates the album
    $OK = false;
    // create SQL
    $conn = dbConnect('admin');
    $sql = "UPDATE Albums SET AlbumName = '$newAlbumName', ImgType = '$extension' WHERE AlbumID = $currentAlbumID";
    $updateAlbum = $conn->query($sql);
    if ($updateAlbum) {
        $sqlD = "DELETE FROM songs WHERE AlbumID = $albumID";
        $deleteSongs = $conn->query($sqlD);
        if ($deleteSongs) {
            $songlist= [];
            $m = 0;
            while ($m <= 20) {
                $songc = 'song' . $m;
                if (!empty($_POST["$songc"])) {
                    $songNameC = $_POST["$songc"];
                    $songNameC = preg_replace('/[^a-zA-Z0-9\- ]/', '', $songNameC);
                    $songNameC = str_replace(' ', ".", $songNameC);
                    if ($songNameC) {$songlist[] = $songNameC;}
                    if (!in_array($songNameC, $songlist)) {
                        $error[] = "Could not upload $songNameC.";
                    }
                }
                $m++;
                }
                // sends the songs to the db
                foreach ($songlist as $key => $value) {
                $sqlI = "INSERT INTO songs (AlbumID, Name) VALUES ($currentAlbumID, '$value')";
                $newSong = $conn->query($sqlI);
            }
            $updated = true;
        }
    }

    //

    }
    // else {
    //     $errors[] = "The database cannot currently be reached...";
    // }

//     $sql3 = 'SELECT AlbumID FROM Albums WHERE AlbumID = ? ORDER By dateCreated DESC LIMIT 1';
//     // bind parameters and execute statement
    // $stmt = $conn->stmt_init();
    // if ($stmt->prepare($sql)) {
        // bind parameters and execute statement
        // $stmt->execute();
        // $stmt->bind_param('i', $_GET['AlbumID']);
        // $stmt->bind_result($albumID);
        // while ($stmt->fetch()) {
        //     foreach ($songlist as $value) {
        //         $sql4 = "INSERT INTO Songs (AlbumID, Name) VALUES ('$currentAlbumID', '$value')";
        //         // bind parameters and execute statement
        //         if ($stmt->prepare($sql4)) {
        //             // bind parameters and execute statement
        //             $stmt->execute();
        //             if ($stmt->affected_rows > 0) {
        //                 $OK = true;
        //             }
        //         }
        //     }
        // }

//         // header('Location: http://localhost:81/phpsols/admin/blog_list_mysqli.php');
//         // exit;
//         }
    // $updatedAlbum = mysqli_query($sql, MYSQLI_STORE_RESULT);}
    // bind parameters and execute statement

//     $sql3 = 'SELECT AlbumID FROM Albums WHERE AlbumID = ? ORDER By dateCreated DESC LIMIT 1';
//     // bind parameters and execute statement
//     $stmt = $conn->stmt_init();
//     if ($stmt->prepare($sql3)) {
//         // bind parameters and execute statement
//         $stmt->execute();
//         $stmt->bind_param('i', $_GET['AlbumID']);
//         $stmt->bind_result($albumID);
//         while ($stmt->fetch()) {
//             foreach ($songlist as $value) {
//                 $sql4 = "INSERT INTO Songs (AlbumID, Name) VALUES ('$currentAlbumID', '$value')";
//                 // bind parameters and execute statement
//                 if ($stmt->prepare($sql4)) {
//                     // bind parameters and execute statement
//                     $stmt->execute();
//                     if ($stmt->affected_rows > 0) {
//                         $OK = true;
//                     }
//                 }
//             }
//         }
//         // header('Location: http://localhost:81/phpsols/admin/blog_list_mysqli.php');
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

// if form has been submitted, update record
// if (isset($_POST['update'])) {
//     // prepare update query
//     $sql = 'INSERT INTO Albums (AlbumName, ImgType) VALUES (?, ?) WHERE AlbumID = ?';
//     if ($stmt->prepare($sql)) {
//         $stmt->bind_param('i', $_GET['AlbumID']);
//         $done = $stmt->execute();
//     }
// }
// redirect if $_GET['AlbumID'] not defined
// if ($done || !isset($_GET['AlbumID'])) {
//     header('Location: http://localhost:81/phprevamp/admin.php');
//     exit;
// }
// get error message if query fails
$s = 1;

// if (isset($_POST['update'])) {
//     while ($s < 20) {
//         $songNum = 'song'.$s;
//         $currentSong = $_POST["$songNum"];
//         echo '$currentSong';
//         $s++;
//     }
// }
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>var page = 'update'</script>
    <script src="../js/limitSongList.js" defer></script>
</head>

<body class="container">
<section>
<?php include '../includes/HTML/adminNav.php';
?>
<h1 class="pb-3"><i class="fas fa-users-cog"></i> Albums | Update Album</h1>
<?php if (!empty($error)) {
    echo "<p class='warning'>Error: $error</p>";
}
if (!$updated) {
if ($currentAlbumID == 0) {?>
    <p class="warning">Invalid Request: record does not exist.</p>
<?php } else { ?>
<form method="post" actionb="" class="" enctype="multipart/form-data" name="update" id="updateForm">
    <p class="col-12 col-md-8 row">
        <label for="name" class="col-12 col-sm-3 ">Album Name:</label>
        <input name="name" type="text" id="name" value="<?= $albumName; ?>" class="col-10 col-sm-9 ml-3 ml-sm-0">
    </p>

    <p class="col-12 col-md-8 row">
        <label for="cover"  class="col-12 col-sm-3">Album Cover:</label>
        <input name="cover" type="file" id="cover" class="col-10 col-sm-9 ml-0 ml-sm-n3">
    </p>

    <h3 class="pb-3 pl-2 tracks">Track List:</h3>
    <div id="songs" class="col-12">
        <p class="col-10 row">
            <label for="song1 hide" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song1" type="text" id="song1"  class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo  htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row">
            <label for="song2" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song2" type="text" id="song2" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row">
            <label for="song3" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song3" type="text" id="song3" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song4" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song4" type="text" id="song4" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song5" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song5" type="text" id="song5" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song6" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song6" type="text" id="song6" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song7" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song7" type="text" id="song7" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song8" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song8" type="text" id="song8" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song9" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song9" type="text" id="song9" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song10" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song10" type="text" id="song10" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song11" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song11" type="text" id="song11" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song12" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song12" type="text" id="song12" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song13" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song13" type="text" id="song13" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song14" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song14" type="text" id="song14" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song15" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song15" type="text" id="song15" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song16" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song16" type="text" id="song16" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song17" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song17" type="text" id="song17" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song18" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song18" type="text" id="song18" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>
        <p class="col-10 row hide">
            <label for="song19" class="col-3 col-md-2 col-xl-1">Title <?= $s++ ?>:</label>
            <input name="song19" type="text" id="song19" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>


        <p class="col-10 row hide">
            <label for="song20" class="col-3 col-md-2 col-xl-1">Title: <?= $s++ ?></label>
            <input name="song20" type="text" id="song20" class="col-9 col-md-10 col-xl-11" value="<?php if ($k <= $kCount) {echo htmlentities($song[$k]); $k++;}?>">
        </p>

    </div>
    <p class="col-6 col-md-2">
        <a class="songBtn" id="newSong">+</a>
    </p>
    <p>
        <input name="albumID" type="hidden" value="<?= htmlentities($currentAlbumID); ?>">
        <input type="submit" name="update" value="Update Entry" id="update" class="btn btn-outline-info">
        <a href="http://localhost:81/phprevamp/admin/album_list.php" id="cancel_delete" class="btn btn-outline-danger">Cancel</a>
    </p>

</form>
<?php } }else {header('Location:album_list.php');} ?>
</section>
</body>
</html>
<?php
ob_end_flush();
?>
