<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูล
    $sql = "SELECT status_post_id AS id, image FROM status_post WHERE image IS NOT NULL AND image != ''";
    $query = $conn->prepare($sql);
    $query->execute();

    // ดึงข้อมูลทั้งหมด
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    // ส่งข้อมูลไปยัง JavaScript
    echo "<script>const demo_data = " . json_encode($data) . ";</script>";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Slip</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Slip Viewer</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="dataTableBody">
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="slipModal" tabindex="-1" aria-labelledby="slipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slipModalLabel">View Slip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="slipImage" src="" class="img-fluid" alt="Slip">
            </div>
        </div>
    </div>
</div>

<script>
    // ดึงข้อมูลจาก PHP
    const demo_data = window.demo_data || [];
    const tableBody = document.getElementById('dataTableBody');

    // สร้างตาราง
    demo_data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td><img src="http://localhost/${item.image}" alt="Slip" style="width: 100px; height: auto;"></td>
            <td><button class="btn btn-primary" onclick="viewSlip(${index})" data-bs-toggle="modal" data-bs-target="#slipModal">View Slip</button></td>
        `;
        tableBody.appendChild(row);
    });

    // ฟังก์ชันแสดง Slip
    function viewSlip(index) {
        const item = demo_data[index];
        const slipImage = document.getElementById('slipImage');
        slipImage.src = `http://localhost/${item.image}`;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
