<?php

$conn = mysqli_connect('localhost','ricards', 'task123', 'catalogue_task_1');

   if(!$conn){
      echo 'Connection error'. mysqli_connect_error();
   }

 ?>
