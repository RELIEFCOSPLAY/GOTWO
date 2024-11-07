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
            post.post_id,
            post.pick_up,
            post.at_drop,
            post.date,
            post.time,
            post.price,
            post.status_helmet,
            post.check_status,
            table_customer.name AS customer_name,
            table_rider.name AS rider_name,
            status_post.pay AS pay
        FROM 
            post
        LEFT JOIN 
            table_customer ON post.customer_id = table_customer.regis_customer_id
        LEFT JOIN 
            table_rider ON post.rider_id = table_rider.regis_rider_id
        LEFT JOIN 
            status_post ON post.post_id = status_post.status_post_id     
    ");
    $stmt->execute();

    // Fetch all data as an associative array
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($payments);

} catch (PDOException $e) {
    echo json_encode(["error" => "Connection failed: " . $e->getMessage()]);
}
?>
