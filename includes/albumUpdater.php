<?php
namespace includes\AlbumUpdater;

class AlbumUpdater {
    protected $ID = [];
    protected $albumName = [];
    protected $songNames = [];
    protected $errors = [];

    public function __construct($albumID, $albumName, $songName) {
        $this->ID = $albumID;
        $this->albumName = $albumName;
        $this->songNames = $songName;
    }

        // prepare SQL query
    $sql1 = 'SELECT a.AlbumID, a.AlbumName, s.Name FROM Albums AS a JOIN Songs AS s ON a.AlbumID=s.AlbumID WHERE a.AlbumID = ?';
    $stmt = $conn->stmt_init();
    $stmt->prepare($sql1);
    if ($stmt->prepare($sql1)) {
        //bind the query parameter
        $stmt->bind_param('i', $_GET['AlbumID']);
        // execute the query, and fetch the result
        $OK = $stmt->execute();
        // bind the results to the variables
        $stmt->bind_result($albumID, $albumName, $songName);
        $i = 0;
       while ($stmt->fetch()) {
            echo $albumID;
            $albumName = str_replace('.', ' ', $albumName);
            echo $albumName;
            $songName = str_replace('.', ' ', $songName);
            echo $songName;
            $song[$i] = $songName;
            $kCount = (count($song) - 1);
            $i++;
       }

    }

}
