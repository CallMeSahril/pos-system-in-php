<?php

define('DB_Server', "localhost");
define('DB_USERNAME', "root");
define('DB_PASSWORD', "");
define('DB_DATABASE', "pos_system_php");

$conn = mysqli_connect(DB_Server, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
