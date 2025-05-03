<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "Kishor@2025", "kcet_project");
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Fetch dropdown values (subjects and years)
$subjects = $conn->query("SELECT DISTINCT subject FROM pyqs ORDER BY subject");
if (!$subjects) {
    die("Error fetching subjects: " . $conn->error);
}

$years = $conn->query("SELECT DISTINCT year FROM pyqs ORDER BY year DESC");
if (!$years) {
    die("Error fetching years: " . $conn->error);
}

$downloadFile = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject = $_POST["subject"];
    $year = $_POST["year"];

    // Prepare and execute the query to get the filename for the selected subject and year
    $stmt = $conn->prepare("SELECT filename FROM pyqs WHERE subject = ? AND year = ?");
    $stmt->bind_param("si", $subject, $year);
    $stmt->execute();
    $stmt->bind_result($filename);

    // Check if the file exists
    if ($stmt->fetch()) {
        $downloadFile = "kcet/" . $filename; // Path where PDFs are stored
    } else {
        // If no file is found for the selected subject and year
        $downloadFile = null;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCET PYQs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f7f7f7;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px #ccc;
            width: 300px;
            margin: auto;
        }
        label, select {
            margin: 10px 0;
            display: block;
            width: 100%;
        }
        button {
            margin-top: 10px;
            padding: 8px 16px;
            border: none;
            background: #4CAF50;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        a.download-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📚 Download KCET PYQs</h2>

    <form method="post">
        <label for="subject">Subject:</label>
        <select name="subject" id="subject" required>
            <option value="">-- Select Subject --</option>
            <?php while ($row = $subjects->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['subject']) ?>"><?= htmlspecialchars($row['subject']) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="year">Year:</label>
        <select name="year" id="year" required>
            <option value="">-- Select Year --</option>
            <?php while ($row = $years->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($row['year']) ?>"><?= htmlspecialchars($row['year']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">🔽 Find PDF</button>

        <?php if ($downloadFile): ?>
            <!-- Display download link if a file is found -->
            <a class="download-link" href="<?= $downloadFile ?>" download>📥 Click to Download</a>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <!-- Display message if no file is found -->
            <p style="color: red; text-align: center;">No file found for the selected subject and year.</p>
        <?php endif; ?>
    </form>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
