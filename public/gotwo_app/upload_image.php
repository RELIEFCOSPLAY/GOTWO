<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ตรวจสอบว่าได้รับไฟล์หรือไม่
    if (!isset($_FILES['image']) || !isset($_POST['status_post_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid input data.",
            "files" => $_FILES,
            "post" => $_POST
        ]);
        exit;
    }

    $image = $_FILES['image'];
    $status_post_id = intval($_POST['status_post_id']);

    // ตรวจสอบข้อผิดพลาดของไฟล์
    if ($image['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "File upload error: " . $image['error']]);
        exit;
    }

    // ตรวจสอบประเภทไฟล์ที่อนุญาต
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($image['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Invalid file type: " . $fileType]);
        exit;
    }

    // สร้างชื่อไฟล์แบบสุ่ม
    $fileName = uniqid() . "." . pathinfo($image['name'], PATHINFO_EXTENSION);
    $filePath = "uploads/" . $fileName;

    // ย้ายไฟล์ไปยังโฟลเดอร์
    if (!move_uploaded_file($image['tmp_name'], $filePath)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to save the file.",
            "debug" => error_get_last()
        ]);
        exit;
    }

    // อัปเดต path ของรูปในฐานข้อมูล
    $sql = "UPDATE status_post SET image = :image WHERE status_post_id = :status_post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':image', $filePath);
    $stmt->bindParam(':status_post_id', $status_post_id);

    if ($stmt->execute()) {
        // ดึงข้อมูลชื่อรูปภาพจากฐานข้อมูล
        $sqlFetch = "SELECT image FROM status_post WHERE status_post_id = :status_post_id";
        $stmtFetch = $conn->prepare($sqlFetch);
        $stmtFetch->bindParam(':status_post_id', $status_post_id);
        $stmtFetch->execute();
        $result = $stmtFetch->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode([
                "success" => true,
                "message" => "Database updated and fetched successfully.",
                "image" => $result['image'] // ส่งชื่อรูปกลับไป
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to fetch image name."
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update database.",
            "debug" => $stmt->errorInfo()
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
