<?php
// เปิดการแสดงข้อผิดพลาดสำหรับ Debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

// ตั้งค่า Content-Type เป็น JSON
header('Content-Type: application/json');

try {
    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ตรวจสอบว่าคำขอเป็น POST หรือไม่
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับข้อมูลจากฟอร์ม
        $input_username = $_POST['username'] ?? '';
        $input_password = $_POST['password'] ?? '';

        // ตรวจสอบว่ามีข้อมูลในฟอร์มครบถ้วนหรือไม่
        if (empty($input_username) || empty($input_password)) {
            echo json_encode(["status" => "error", "message" => "Please fill in all fields."]);
            exit;
        }

        // ใช้ Prepared Statements ป้องกัน SQL Injection
        $stmt = $conn->prepare("SELECT id, username, password FROM table_admin WHERE username = :username");
        $stmt->bindParam(':username', $input_username);
        $stmt->execute();

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $input_password === $user['password']) {
            // ตั้งค่าข้อมูล Session เมื่อเข้าสู่ระบบสำเร็จ
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo json_encode([
                "status" => "success",
                "message" => "Login successful!",
                "redirect" => "/public/gotwo_app/Dashboard.php"
            ]);
        } else {
            // ส่งข้อความแสดงข้อผิดพลาดเมื่อข้อมูลไม่ถูกต้อง
            echo json_encode(["status" => "error", "message" => "Invalid username or password."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    }
} catch (PDOException $e) {
    // ส่งข้อความข้อผิดพลาดเมื่อการเชื่อมต่อฐานข้อมูลล้มเหลว
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
}
?>
