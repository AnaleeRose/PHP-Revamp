<?php
require_once 'connection.php';
if ($conn = dbConnect('admin')) {
    echo 'Connection successful!';
}

