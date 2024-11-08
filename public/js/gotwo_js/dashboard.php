<?php
   header('Content-Type: application/json');
   require_once 'Dashboard.php';

   $sqlQuery ="SELECT + FROM table_custome ORDER BY regis_customer_id";
   $result = mysqli_query($conn, $sqlQuery);

   $data = array();

   foreach($result as $row){
      $data[] =$row;
   }

   mysqli_close($conn);

   echo json_encode($data);

?>