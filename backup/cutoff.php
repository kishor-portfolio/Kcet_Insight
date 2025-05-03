<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KCET Cutoff Search</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { margin-bottom: 20px; }
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid black; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Search KCET Cutoff</h2>
    <a href="logout.php">Logout</a> <!-- Logout Button -->

    <form method="GET" action="">
        <label>College Name:</label>
        <input type="text" name="college" required>

        <label>Branch:</label>
        <input type="text" name="branch" required>

        <label>Category:</label>
        <input type="text" name="category" required>

        <label>Select Round:</label>
        <select name="round" required>
            <option value="1">Round 1</option>
            <option value="2">Round 2</option>
            <option value="3">Round 3</option>
        </select>

        <button type="submit">Search</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["college"], $_GET["branch"], $_GET["category"], $_GET["round"])) {
        $college = $conn->real_escape_string($_GET["college"]);
        $branch = $conn->real_escape_string($_GET["branch"]);
        $category = $conn->real_escape_string($_GET["category"]);
        $round = (int)$_GET["round"]; // Convert to integer

        // Fetch cutoff data
        $sql = "SELECT c.college_name, c.branch_name, c.category, r.round_name, c.cutoff_value 
                FROM cutoffs c 
                JOIN rounds r ON c.round_id = r.round_id
                WHERE c.college_name = '$college' 
                AND c.branch_name = '$branch' 
                AND c.category = '$category' 
                AND c.round_id = $round";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h3>Search Results:</h3>";
            echo "<table><tr><th>College</th><th>Branch</th><th>Category</th><th>Round</th><th>Cutoff Rank</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['college_name']}</td>
                        <td>{$row['branch_name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['round_name']}</td>
                        <td>{$row['cutoff_value']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for the selected criteria.</p>";
        }
    }
    ?>
</body>
</html>
