<?php
header('Content-Type: application/json; charset=utf-8');
include("config.php");

// รับค่าที่ส่งมาจาก Flutter
// $regis_rider_id = $_POST['regis_rider_id'];
$img_profile = $_POST['img_profile'];
$name = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$gender = $_POST['gender'];
$password = $_POST['password'];
$img_id_card = $_POST['img_id_card'];
$img_driver_license = $_POST['img_driver_license'];
$img_car_picture = $_POST['img_car_picture'];
$img_car_registration = $_POST['img_car_registration'];
$img_act = $_POST['img_act'];
$expiration_date = $_POST['expiration_date'];
$car_registration = $_POST['car_rigistration']; // spelling ตามฐานข้อมูล
$car_brand = $_POST['car_brand'];
$bank = $_POST['bank'];
$name_account = $_POST['name_account'];
$number_bank = intval($_POST['number_bank']);
$status_rider = intval($_POST['status_rider']);
$reason = $_POST['reason'];

// เตรียมคำสั่ง SQL สำหรับการ INSERT
$sql = "INSERT INTO `table_rider` 
        (`img_profile`, `name`, `email`, `tel`, `gender`, `password`, `img_id_card`, `img_driver_license`, `img_car_picture`, `img_car_registration`, `img_act`, `expiration_date`, `car_rigistration`, `car_brand`, `bank`, `name_account`, `number_bank`, `status_rider`, `reason`) 
        VALUES 
        ('$img_profile', '$name', '$email', '$tel', '$gender', '$password', '$img_id_card', '$img_driver_license', '$img_car_picture', '$img_car_registration', '$img_act', '$expiration_date', '$car_registration', '$car_brand', '$bank', '$name_account', '$number_bank', '$status_rider', '$reason')";

if ($conn->query($sql)) {
    echo "insert Sucsess";
} else {
    echo "Error insert !";
}

?>