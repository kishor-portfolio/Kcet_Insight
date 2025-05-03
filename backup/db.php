<?php
$servername = "localhost"; // Change if needed
$username = "root";        // Your MySQL username
$password = "Kishor@2025";            // Your MySQL password (leave empty if none)
$database = "kcet_project";     // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>
