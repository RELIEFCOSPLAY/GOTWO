<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");

//-------------------------------------------------------
$action = $_POST['action'];
$status =  intval($_POST['status']);
$status_post_id = intval($_POST['status_post_id']);
$Comment = $_POST['Comment'];
$pay = $_POST['pay'];
//-------------------------------------------------------

if ($action == "accept") {
    //Accept
    $update_sql = "UPDATE `status_post` SET `status` = '$status', `Comment` = '$Comment' , `pay` = '$pay' WHERE `status_post_id` = '$status_post_id';";

    if ($conn->query($update_sql)) {
        echo "Update Success";
    } else {
        echo "Error updating post!";
    }
} elseif ($action == "cancel") {
    //Cencal
    $update_sql = "UPDATE `status_post` SET `status` = '$status', `Comment` = '$Comment'  , `pay` = '$pay'  WHERE `status_post_id` = '$status_post_id';";

    if ($conn->query($update_sql)) {
        echo "Update Success";
    } else {
        echo "Error updating post!";
    }
} else {
    echo "Can find action ";
}
// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>