<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCET College Allotment System</title>
</head>
<body>

    <h1>Welcome to the KCET College Allotment System</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Welcome, User!</p>
        <a href="cutoff.php">Search KCET Cutoffs</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a> | <a href="signup.php">Sign Up</a>
    <?php endif; ?>

</body>
</html>
