<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // ตรวจสอบรหัสผ่าน
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: Dashboard.php"); // เปลี่ยนไปยังหน้า Dashboard
            exit();
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "No such user found!";
    }
}
?>
