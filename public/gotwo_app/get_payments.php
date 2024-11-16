<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Write a SQL query to retrieve data from the post table and related tables
    $stmt = $conn->prepare("
        SELECT 
        status_post.status_post_id,
        status_post.status, 
        status_post.reason, 
        status_post.pay, 
        status_post.review, 
        status_post.comment,
        post.post_id AS post_id, 
        table_customer.name AS customer_name,
        table_customer.regis_customer_id AS customer_id, 
        table_rider.name AS rider_name, 
        table_rider.regis_rider_id AS rider_id, 
        table_rider.gender AS rider_gender,
        table_rider.tel AS rider_tel,
        post.pick_up AS pick_up, 
        post.comment_pick AS comment_pick, 
        post.at_drop AS at_drop, 
        post.comment_drop AS comment_drop, 
        post.date AS date, 
        post.time AS time,
        post.status_helmet AS status_helmet,
        post.price AS price,
        post.check_status AS check_status
    FROM status_post
    INNER JOIN post ON status_post.post_id = post.post_id
    INNER JOIN table_customer ON status_post.customer_id = table_customer.regis_customer_id
    INNER JOIN table_rider ON post.rider_id = table_rider.regis_rider_id;
     
    ");
    $stmt->execute();

    // Fetch all data as an associative array
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($payments);
} catch (PDOException $e) {
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
}
