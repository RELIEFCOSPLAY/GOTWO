<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gotwo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input_username = $_POST['username'] ?? '';
        $input_password = $_POST['password'] ?? '';

        $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $input_username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($input_password, $user['password'])) {
            echo json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid username or password."]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $e->getMessage()]);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="/public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/public/css/css_gotwo/login_gotwo_test2.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <span></span>
        <span></span>
        <span></span>
        <form id="loginForm">
    <img src="/public/img/pngegg.png" class="img_">
     <h1>GOTWO</h1>
     <div class="input-box">
         <input type="text" id="username" name="username" placeholder="Username" required autocomplete="off">
         <i class="bi bi-person-fill"></i>
     </div>
     <div class="input-box">
         <input type="password" id="password" name="password" placeholder="Password" required autocomplete="off">
         <i class="bi bi-key-fill" id="togglePassword" onclick="togglePasswordVisibility()"></i>
     </div>
     <button type="submit" class="btn">LOGIN</button>
    </form>

    </div>
    <?php 
        // ดึงข้อมูลจากฐานข้อมูล 
        $sql = "SELECT name, username, password, img_profile FROM table_admin;
";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // แปลงข้อมูลเป็น JSON เพื่อส่งไปยัง JavaScript
        $adminDataJSON = json_encode($fetch, JSON_UNESCAPED_UNICODE);
        ?>
        
            
    ?>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-key-fill");
                toggleIcon.classList.add("bi-eye-fill");  // Change icon to eye icon when visible
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-fill");
                toggleIcon.classList.add("bi-key-fill");  // Change icon back to key icon when hidden
            }
        }
 //============================================================================================

 document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault(); // หยุดการ submit ปกติ

    const formData = new FormData();
    formData.append("username", document.getElementById("username").value);
    formData.append("password", document.getElementById("password").value);

    try {
        const response = await fetch('/public/gotwo_app/login_gotwo2.php', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const result = await response.json();

        if (result.status === "success") {
            alert(result.message);
            window.location.href = "/public/gotwo_app/Dashboard.php"; // เปลี่ยนเส้นทางเมื่อเข้าสู่ระบบสำเร็จ
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('There was an error processing your request.');
    }
});


    </script>
</body>
</html>