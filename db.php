<?php
// Start the session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root"; // Change to your database username
$password = "Kishor@2025"; // Updated password
$dbname = "kcet_project"; // Updated database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: You can add any queries or functions here to interact with the database

// For testing the connection
?>
