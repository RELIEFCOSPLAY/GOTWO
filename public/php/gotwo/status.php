<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");

$sql = "
    SELECT 
        post.pick_up, 
        post.comment_pick, 
        post.at_drop, 
        post.date, 
        post.time, 
        post.price, 
        post.status_helmet, 
        table_rider.regis_rider_id AS rider_id, 
        table_rider.gender AS rider_gender,
        table_rider.name AS rider_name
    FROM post
    INNER JOIN table_rider ON post.rider_id = table_rider.regis_rider_id";

$result = mysqli_query($conn, $sql);

$response = array();

// สร้าง JSON ที่ถูกต้อง
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tb_pos = array();
        $tb_pos["pick_up"] = $row['pick_up'];
        $tb_pos["commpick"] = $row['comment_pick'];
        $tb_pos["at_drop"] = $row['at_drop'];
        $tb_pos["date"] = $row['date'];
        $tb_pos["time"] = $row['time'];
        $tb_pos["price"] = $row['price'];
        $tb_pos["status_helmet"] = $row['status_helmet'];
        $tb_pos["rider_id"] = $row['rider_id'];
        $tb_pos["rider_gender"] = $row['rider_gender'];
        $tb_pos["rider_name"] = $row['rider_name'];

        array_push($response, $tb_pos);
    }
} else {
    $response["error"] = "No data found.";
}

// ส่งข้อมูล JSON กลับไปยัง Flutter
echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
mysqli_close($conn);

?>