<?php
include("config.php"); // เชื่อมต่อฐานข้อมูล

// $email = $_POST['email'];
$password = 1234; // รหัสผ่านที่แฮชจาก Flutter

// ค้นหาผู้ใช้
// $sql = "SELECT * FROM table_rider WHERE email = '$email'";
// $result = mysqli_query($conn, $sql);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// if (mysqli_num_rows($result) > 0) {
//     $row = mysqli_fetch_assoc($result);
$storedPasswordHash = '$2y$10$fG8pLMA9s6RWH'; // รหัสผ่านที่แฮชในฐานข้อมูล

if (password_verify($password, $hashed_password)) { // เปรียบเทียบรหัสผ่านที่แฮช
    echo json_encode("Success");
    echo $hashed_password;
} else {
    echo json_encode("Error");
}
// } else {
//     echo json_encode("Error");
// }