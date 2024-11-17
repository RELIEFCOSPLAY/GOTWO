<?php
header('Content-Type: application/json');
require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['regis_rider_id'], $data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
    exit;
}

$regis_rider_id = $data['regis_rider_id'];
$status = $data['status'];

$sql = "UPDATE table_rider SET status_rider = :status WHERE regis_rider_id = :regis_rider_id";
$query = $conn->prepare($sql);
$query->bindParam(':status', $status, PDO::PARAM_INT);
$query->bindParam(':regis_rider_id', $regis_rider_id, PDO::PARAM_INT);

$response = ['success' => false];

if ($query->execute()) {
    $response['success'] = true;
    $response['message'] = 'Status updated successfully';
} else {
    $response['message'] = 'Failed to update status';
}

echo json_encode($response);
?>
