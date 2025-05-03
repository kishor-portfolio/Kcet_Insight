<?php
session_start();
include('db.php');  // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_name = trim($_POST['college_name']);
    $branch_name = trim($_POST['branch_name']);
    $rank_category = trim($_POST['rank_category']);

    // Fetch cutoffs with round names
    $query = "SELECT c.college_name, c.branch_name, c.rank_category, c.cutoff_value, r.round_name
              FROM cutoffs c
              JOIN rounds r ON c.round_id = r.round_id
              WHERE c.college_name = ? AND c.branch_name = ? AND c.rank_category = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$college_name, $branch_name, $rank_category]);
    $cutoffs = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KCET Cutoff Results</title>
</head>
<body>
    <h1>KCET Cutoff Results</h1>

    <?php if (!empty($cutoffs)): ?>
        <table border="1">
            <tr>
                <th>College Name</th>
                <th>Branch Name</th>
                <th>Rank Category</th>
                <th>Cutoff Value</th>
                <th>Round Name</th>
            </tr>
            <?php foreach ($cutoffs as $cutoff): ?>
                <tr>
                    <td><?= htmlspecialchars($cutoff['college_name']) ?></td>
                    <td><?= htmlspecialchars($cutoff['branch_name']) ?></td>
                    <td><?= htmlspecialchars($cutoff['rank_category']) ?></td>
                    <td><?= htmlspecialchars($cutoff['cutoff_value']) ?></td>
                    <td><?= htmlspecialchars($cutoff['round_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No cutoffs found for the selected criteria.</p>
    <?php endif; ?>

    <a href="cutoff.php">Search Again</a>
</body>
</html>
