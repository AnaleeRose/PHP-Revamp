<?php
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

$songlist = [];
if (isset($_POST['insert']))
{
// sql code will go here...
}

require_once 'includes/upload.php';
use includes\Upload;
if (isset($_POST['insert']) && !$errors && !$missing) {
    $destination = '../images/user-images/';
    $max = 5000000;
    require_once 'includes/upload.php';
    $albumName = $_POST['name'];
    $albumName = preg_replace('/[^a-zA-Z0-9]/', '', $albumName);
    $extension = pathinfo($_FILES["cover"]["name"], PATHINFO_EXTENSION);
    try {
        $loader = new Upload($destination, $albumName);
        $loader->setMaxSize($max);
        $loader->upload();
        // $loader->checkName($file);
        $result = $loader->getMessages();
        echo $albumName;
        echo $extension;
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
    <link href="http://localhost:81/phprevamp/css/admin.css" rel="stylesheet" type="text/css">

<!--Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet">

<!-- Script -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<!--     <script src="js/jquery.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
</head>

<body class="container">
<?php
include '../includes/title.php';
include '../includes/adminNav.php';
?>
<section>
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
            echo "<li>$message</li>";
        }
        echo '</ul>';
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
    </div>

<form method="post" actionb="" class="" enctype="multipart/form-data" name="insert">
    <p class="col-12 col-md-8 row">
        <label for="name" class="col-12 col-sm-3 col-xl-2">Album Name:</label>
        <input name="name" type="text" id="name" class="col-10 col-sm-9 col-xl-10 ml-3 ml-sm-0">
    </p>
    <p class="col-12 col-md-8 row">
        <label for="cover"  class="col-12 col-sm-3 col-xl-2">Album Cover:</label>
        <input name="cover" type="file" id="cover" class="col-10 col-sm-9 col-xl-10 ml-0 ml-sm-n3">
    </p>
    <h3 class="pb-3 pl-2">Track List:</h3>
    <div id="songs" class="col-12">
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
            <label for="song5" class="col-3 col-md-2 col-xl-1">Title:</label>
            <input name="song5" type="text" id="song4" class="col-9 col-md-10 col-xl-11">
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
    <script>
        var songLimit = false;
        var songBtn = document.getElementById("newSong");
        var songs = document.getElementById("songs");
        songBtn.addEventListener("click", addSong);
        var hide = songs.querySelectorAll(".hide");
        var i = 0;
        function addSong() {
            var hidden = document.querySelector("p.hidden");
            if (hidden) {
                hidden.classList.remove('hidden');
            } else {
                var errorList = document.getElementById("errors");
                var p = document.createElement("p");
                var limitNotice = document.createTextNode("You've hit the song limit!");
                p.classList.add("noMore")
                if (!(document.querySelector(".noMore"))) {
                    p.appendChild(limitNotice);
                    errorList.appendChild(p);
                }

            }
        }

         function limit() {
            var i = 0;
           if (document.getElementById("song4").value == '') {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song5").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song6").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song7").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song8").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song9").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song10").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song11").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song12").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song13").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song14").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song15").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song16").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song17").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song18").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song19").value)) {
            hide[i].classList.add('hidden');
           };
           i++;
           if (!(document.getElementById("song20").value)) {
            hide[i].classList.add('hidden');
           };
           }
        limit();
        // cool function that added new song inputs... doesnt work with php ;-;
        // function addSong() {
        //     if (songLimit == false) {
        //     var p = document.createElement("p");
        //     var label = document.createElement("label");
        //     var title = document.createTextNode("Title:");
        //     var input = document.createElement("input");
        //     p.classList.add("col-10", "row");
        //     label.setAttribute("for", "song".concat(i));
        //     label.classList.add("col-3", "col-md-2", "col-xl-1");
        //     label.appendChild(title);
        //     input.setAttribute("name", "song".concat(i));
        //     input.setAttribute("id", "song".concat(i));
        //     input.setAttribute("type", "text");
        //     input.classList.add("col-9", "col-md-10", "col-xl-11");
        //     p.appendChild(label);
        //     p.appendChild(input);
        //     songs.appendChild(p);
        //     limit();
        //     } else {


        //     }

        // }

        // function limit() {
        //     if (i <= 15) {
        //     i++} else {
        //         songLimit = true;
        //         var errorList = document.getElementById("errors")
        //         var p = document.createElement("p");
        //         var limitNotice = document.createTextNode("You've hit the song limit!");
        //         p.appendChild(limitNotice);
        //         errorList.appendChild(p);
        //     }
        //     console.log(i)
        // }
    </script>
</body>
</html>
