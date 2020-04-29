<?php

// connecting to database - common for every php file that needs connection

$conn = mysqli_connect('localhost','ricards', 'task123', 'catalogue_task_1');

   if(!$conn){
      echo 'Connection error'. mysqli_connect_error();
   }
   
$orderBy = 'created_at';
$sql = "SELECT * FROM things ORDER BY $orderBy";
$result = mysqli_query($conn, $sql);
$things = mysqli_fetch_all($result, MYSQLI_ASSOC);

 ?>
