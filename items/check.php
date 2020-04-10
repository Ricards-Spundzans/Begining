<?php
if($selected == 1){

   $errors['parametr_2'] = '';
   $errors['parametr_3'] = '';

   if(empty($_POST['dvdSize'])){
         $errors['parametr_1'] = 'Parameter is requied <br />';
   }else {
     $parameter_1 = $_POST['dvdSize'];
     if(preg_match($pattern2, $_POST['dvdSize']) == '0' ){
         $errors['parametr_1'] = 'Wrong format';
     }else{

         $errors['parametr_1'] = '';
     }
   }

 }elseif($selected == 3){

    $errors['parametr_2'] = '';
    $errors['parametr_3'] = '';

    if(empty($_POST['bookWeight'])){
          $errors['parametr_1'] = 'Parameter is requied<br />';
    }else {
      $parameter_1 = $_POST['bookWeight'];
      if(preg_match($pattern2, $_POST['bookWeight']) == '0' ){
          $errors['parametr_1'] = 'Wrong format';
      }else{

          $errors['parametr_1'] = '';
      }
    }

  }elseif ($selected == 2) {

     if(empty($_POST['parametr_1'])){
        $errors['parametr_1'] = 'Parameter 1 is requied <br />';

     }else {
       $parameter_1 = $_POST['parametr_1'];
       if(preg_match($pattern2, $_POST['parametr_1']) == '0' ){
         $errors['parametr_1'] = 'Wrong format of parameter 1';
       }else{
         $errors['parametr_1'] = '';
       }
     }

     if(empty($_POST['parametr_2'])){
        $errors['parametr_2'] = 'Parameter 2 is requied <br />';
     }else {
       $parameter_2 = $_POST['parametr_2'];
       if(preg_match($pattern2, $_POST['parametr_2']) == '0' ){
         $errors['parametr_2'] = 'Wrong format of parameter 2';
       }else{
         $errors['parametr_2'] = '';
       }
     }

     if(empty($_POST['parametr_3'])){
        $errors['parametr_3'] = 'Parameter 3 is requied <br />';
     }else {
       $parameter_3 = $_POST['parametr_3'];
       if(preg_match($pattern2, $_POST['parametr_3']) == '0' ){
         $errors['parametr_3'] = 'Wrong format of parameter 3';
       }else{
         $errors['parametr_3'] = '';
       }
     }




}else {

}

 ?>
