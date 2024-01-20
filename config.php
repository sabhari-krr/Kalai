<?php
// Connectivity parameters
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_DBName', 'kalai');
// Establishing database connection
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PWD, DB_DBName);

// if ($conn) {
//     echo "Connection eshtablished";
// } else {
//     echo "Collection failed";
// }
