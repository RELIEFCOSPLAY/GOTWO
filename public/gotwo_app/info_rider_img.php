<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regis_rider_id'])) {
        $riderId = $_GET['regis_rider_id'];

        $sql = "SELECT img_id_card FROM table_rider WHERE regis_rider_id = :riderId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':riderId', $riderId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo json_encode(['success' => true, 'img_id_card' => $result['img_id_card']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Image not found']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
