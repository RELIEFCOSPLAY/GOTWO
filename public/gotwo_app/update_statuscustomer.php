<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['regis_customer_id'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$regis_customer_id = $data['regis_customer_id'];
$status = $data['status'];

$sql = "UPDATE table_customer SET status_customer = :status WHERE regis_customer_id = :regis_customer_id";
$query = $conn->prepare($sql);
$query->bindParam(':status', $status, PDO::PARAM_INT);
$query->bindParam(':regis_customer_id', $regis_customer_id, PDO::PARAM_INT);

$response = ['success' => false];

if ($query->execute()) {
    $response['success'] = true;
    $response['message'] = 'Status updated successfully';
} else {
    $response['message'] = 'Failed to update status';
}

echo json_encode($response);
?>
