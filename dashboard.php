<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>KCET Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .btn-container {
            margin-top: 40px;
        }
        .btn {
            display: inline-block;
            margin: 20px;
            padding: 20px 40px;
            font-size: 18px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .logout {
            margin-top: 40px;
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }
        .logout:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <h1>Welcome, <?= $_SESSION["email"] ?> 👋</h1>
    <h3>Please choose an option:</h3>

    <div class="btn-container">
        <a href="cutoff.php" class="btn">🏫 KCET Cutoffs</a>
        <a href="pyqs/pyq_new.php" class="btn">📚 KCET PYQs</a>  <!-- Link to PYQs page -->
    </div>

    <a href="logout.php" class="logout">🚪 Logout</a>
</body>
</html>

