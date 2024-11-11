<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");

// รับค่าจาก POST;
$status_post_id = intval($_POST['status_post_id']);
$pay = intval($_POST['pay']);
$status = intval($_POST['status']);
$comment = ($_POST['comment']);
$review = intval($_POST['review']);



// SQL สำหรับการอัปเดตข้อมูลในตาราง status_post
$update_sql = "UPDATE `status_post` 
               SET `review` = '$review', `comment` = '$comment', `status` = '$status', `pay` = '$pay'
               WHERE `status_post_id` = '$status_post_id';";



// ดำเนินการคำสั่ง update
if ($conn->query($update_sql)) {
    echo "Update Success";
} else {
    echo "Error updating post!";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>