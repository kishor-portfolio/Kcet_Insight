<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCET Cutoff Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            border: 5px solid #004085;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
            color: black;
            max-width: 850px;
            text-align: center;
        }
        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid #004085;
        }
        .btn-primary {
            background-color: #ff5733;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #c70039;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            transition: 0.3s;
        }
        .btn-danger:hover {
            background-color: #bb2d3b;
        }
        .btn-info {
            background-color: #17a2b8;
            border: none;
            transition: 0.3s;
            color: white;
        }
        .btn-info:hover {
            background-color: #138496;
        }
        h2 {
            font-weight: 700;
            margin-bottom: 20px;
            color: #004085;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        .form-control {
            border-radius: 8px;
            border: 2px solid #004085;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Search KCET Cutoff</h2>
        
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="college" class="form-control" placeholder="College Name" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="branch" class="form-control" placeholder="Branch" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="category" class="form-control" placeholder="Category" required>
            </div>
            <div class="col-md-2">
                <select name="round" class="form-control" required>
                    <option value="1">Round 1</option>
                    <option value="2">Round 2</option>
                    <option value="3">Round 3</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["college"], $_GET["branch"], $_GET["category"], $_GET["round"])) {
            $college = $conn->real_escape_string($_GET["college"]);
            $branch = $conn->real_escape_string($_GET["branch"]);
            $category = $conn->real_escape_string($_GET["category"]);
            $round = (int)$_GET["round"];

            $sql = "SELECT * FROM cutoffs WHERE college_name = '$college' AND branch_name = '$branch' AND category = '$category' AND round_id = $round";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table table-striped table-bordered mt-3'><tr class='table-dark'><th>College</th><th>Branch</th><th>Category</th><th>Round</th><th>Cutoff Rank</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['college_name']}</td><td>{$row['branch_name']}</td><td>{$row['category']}</td><td>Round {$row['round_id']}</td><td>{$row['cutoff_value']}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='text-danger mt-3 text-center'>No results found.</p>";
            }
        }
        ?>

        <p class="mt-4">Thank you for using KCET Cutoff Search!</p>

        <!-- 🔴 Logout button -->
        <a href="logout.php" class="btn btn-danger mt-2">Logout</a>

        <!-- 📚 PYQs Button -->
        <a href="pyqs/index.php" class="btn btn-info mt-3">📚 View KCET PYQs</a>
    </div>
</body>
</html>
