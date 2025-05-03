<?php
include('db.php');

if (isset($_POST['college_name'])) {
    $college_name = $_POST['college_name'];

    // Fetch branches based on the selected college
    $query = "SELECT DISTINCT branch_name FROM cutoffs WHERE college_name = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$college_name]);
    $branches = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo '<option value="">Select Branch</option>';
    foreach ($branches as $branch) {
        echo '<option value="' . htmlspecialchars($branch) . '">' . htmlspecialchars($branch) . '</option>';
    }
}
?>
