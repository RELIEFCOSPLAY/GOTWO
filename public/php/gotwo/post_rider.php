<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");
//-------------------------------------------------------
$action = $_POST['action'];

if ($action == "INSERT") {
    //insert
    $pick_up = $_POST['pick_up'];
    $comment_pick = $_POST['comment_pick'];
    $at_drop = $_POST['at_drop'];
    $comment_drop = $_POST['comment_drop'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    $status_helmet = $_POST['status_helmet'];
    $customer_id = intval($_POST['customer_id']);
    $rider_id = intval($_POST['rider_id']);


    $sql = $sql = "INSERT INTO `post` (`pick_up`, `comment_pick`, `at_drop`, `comment_drop`, `date`, `time`, `price`, `status_helmet`, `customer_id`, `rider_id`) 
    VALUES ('$pick_up', '$comment_pick', '$at_drop', '$comment_drop', '$date', '$time', '$price', '$status_helmet', '$customer_id', '$rider_id');";

    if ($conn->query($sql)) {
        echo "insert Sucsess";
    } else {
        echo "Error insert !";
    }
}
?>