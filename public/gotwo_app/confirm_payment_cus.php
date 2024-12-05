<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

header('Content-Type: application/json'); 

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['id']) || !isset($input['pay'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE status_post SET pay = :pay WHERE status_post_id = :id");
    $stmt->bindParam(':pay', $input['pay']);
    $stmt->bindParam(':id', $input['id']);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
