<?php
function dbconnect ($usertype, $connectionType = 'mysqli') {
    $host = 'localhost';
    $db = 'imaginedragons';
    if ($usertype == 'admin') {
        $user = 'admin';
        $pwd = 'instructor';
    } elseif ($usertype == 'sadmin') {
        $user = 'sadmin';
        $pwd = '3.14NCream';
    } elseif ($usertype == 'view') {
        $user = 'view';
        $pwd = '';
    } else {
        exit('Unrecongnized user');
    }

    if ($connectionType == 'mysqli') {
        $conn = @ new mysqli($host, $user, $pwd, $db);
        if ($conn->connect_error) {
            exit($conn->connect_error);
        }
        return $conn;
    }
}

