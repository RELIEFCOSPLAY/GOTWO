<?php
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์ของฐานข้อมูล
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
$password = ""; // รหัสผ่านของฐานข้อมูล
$dbname = "data_test"; // ชื่อฐานข้อมูลที่ต้องการเชื่อมต่อ

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
