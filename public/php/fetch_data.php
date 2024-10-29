<?php
include 'db_connect.php';

try {
    $stmt = $conn->prepare("SELECT total_income FROM income ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    // Fetch the result
    $incomeData = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($incomeData); // Encode the result as JSON
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
