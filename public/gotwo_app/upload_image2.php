<?php
// การตั้งค่าฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่าไฟล์ถูกอัปโหลด
if (isset($_FILES['img_qr_admin']) && isset($_POST['status_post_id'])) {
    $status_post_id = $_POST['status_post_id'];
    $uploadDir = "uploads/";
    $uploadPath = $uploadDir . basename($_FILES['img_qr_admin']['name']);
    $fullPath = $_SERVER['DOCUMENT_ROOT'] . "/data_test/" . $uploadPath;

    // ย้ายไฟล์ที่อัปโหลดไปยังโฟลเดอร์ที่กำหนด
    if (move_uploaded_file($_FILES['img_qr_admin']['tmp_name'], $fullPath)) {
        // เพิ่มข้อมูลลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO images (status_post_id, file_path) VALUES (?, ?)");
        $stmt->bind_param("is", $status_post_id, $uploadPath);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "File uploaded and saved to database.",
                "file" => $uploadPath,
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to save file information in database.",
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to upload file.",
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded or missing status_post_id.",
    ]);
}

$conn->close();
?>
