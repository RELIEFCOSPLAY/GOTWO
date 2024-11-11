<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");

// รับค่าจาก POST;
$status_post_id = intval($_POST['status_post_id']);
$pay = intval($_POST['pay']);
$comment = ($_POST['comment']);
$status = intval($_POST['status']);

// SQL สำหรับการอัปเดตข้อมูลในตาราง status_post
$update_sql = "UPDATE `status_post` 
               SET `comment` = '$comment', `pay` = '$pay', `status` = '$status'
               WHERE `status_post_id` = '$status_post_id';";

// ดำเนินการคำสั่ง update
if ($conn->query($update_sql)) {
    echo "Update Success";
} else {
    echo "Error updating post!";
}

?>