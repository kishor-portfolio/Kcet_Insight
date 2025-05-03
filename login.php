<?php
session_start();
include('db.php');

// Greet the user based on time
$hour = date('H');
if ($hour < 12) {
    $greeting = "Good morning! 🌅";
} elseif ($hour < 18) {
    $greeting = "Good afternoon! ☀️";
} else {
    $greeting = "Good evening! 🌙";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = $user["name"]; // Store name for dashboard
            $_SESSION["user_id"] = $user["id"]; // Store user ID for session control
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password. Try again.";
        }
    } else {
        $_SESSION['error'] = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - KCET Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(21, 34, 214);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .card {
            width: 380px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.95);
        }
        .greeting {
            font-size: 22px;
            font-weight: bold;
            color:rgb(75, 209, 97);
            text-align: center;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color:rgb(226, 27, 87);
            border: none;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color:rgb(84, 221, 118);
        }
        .text-center a {
            color: #007bff;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="greeting"><?php echo $greeting; ?></div>
    <h3 class="text-center">Welcome Back</h3>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign up here</a></p>
</div>

</body>
</html>
