<?php
include('db.php'); // Include the db.php file to test the connection

if ($pdo) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}
?>
