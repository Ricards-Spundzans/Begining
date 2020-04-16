<?php
// errors....
include('config/db_connect.php');

$pattern = '/^(0|[1-9]\d*)(\.\d{1,2})?$/';
$pattern2 = '/^[0-9]*$/';
$displayProduct = $selected = $sku = $skurand =  $name = $price = $dvdSize = $bookWeight = $parameter_1 = $parameter_2 = $parameter_3 ='';
$errors = array('sku' =>' ', 'name' =>' ', 'price' =>' ', 'type' =>' ', 'parametr_1' => ' ', 'parametr_2' => ' ', 'parametr_3' => ' ', 'dvdSize' =>'', 'bookWeight'=>'');

$orderBy = 'created_at';
$sql = "SELECT * FROM things ORDER BY $orderBy";
$result = mysqli_query($conn, $sql);
$things = mysqli_fetch_all($result, MYSQLI_ASSOC);


if(isset($_POST['fsubmit'])){

   if(empty($_POST['selectProduct'])){
      $errors['type'] = 'Please choose type <br />';
   }else {
      $selected = $_POST['selectProduct'];
      $errors['type'] = '';

     include('items/check.php');
   }

  if(empty($_POST['sku'])){
        $errors['sku'] = 'Please choose SKU <br />';
  }else {
        $sku = $_POST['sku'];
        if(preg_match('/CDC/',$_POST['sku']) == '0' && $selected == 1 ){
            $errors['sku'] = 'SKU doesnt contain CDC';
        }elseif (preg_match('/FNF/',$_POST['sku']) == '0' && $selected == 2) {
            $errors['sku'] = 'SKU doesnt contain FNF';
        }elseif (preg_match('/BOB/',$_POST['sku']) == '0' && $selected == 3) {
            $errors['sku'] = 'SKU doesnt contain BOB';
        }else {
            $sku = $_POST['sku'];
            $errors['sku'] = '';
        }
         foreach ($things as $thing) {
            if($thing['sku'] == $_POST['sku']){
               $errors['sku'] = 'This SKU is already taken. Please choose another one';
            }
         }
    }

   if(empty($_POST['name'])){
      $errors['name'] = ' Please choose Name <br />';
   }else {
      $name = $_POST['name'];
      $errors['name'] = '';
   }
   if(empty($_POST['price'])){
      $errors['price'] = ' Please choose Price <br/>';
   }else {
      $price = $_POST['price'];
      if(preg_match($pattern,$_POST['price']) == '0'){
         $errors['price'] = 'Wrong price format. Use integers and only 2 digits after "." <br/> (Please use "." between dollars and cents.)';
      }else{
         $price = number_format($_POST['price'], 2, '.', '');
         $errors['price'] = '';
      }
  }

   if(array_filter($errors)){
      // if array errors has error
   }else{
      $sku = mysqli_real_escape_string($conn, $_POST['sku']);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $price = mysqli_real_escape_string($conn, $price);
      $type = mysqli_real_escape_string($conn, $_POST['selectProduct']);
      $parameter_1 = mysqli_real_escape_string($conn, $parameter_1);
      $parameter_2 = mysqli_real_escape_string($conn, $parameter_2);
      $parameter_3 = mysqli_real_escape_string($conn, $parameter_3);
      //create sql
      $sql = "INSERT INTO things(sku, name, price, type, parameter_1, parameter_2, parameter_3) VALUES('$sku', '$name', '$price', '$type', '$parameter_1', '$parameter_2', '$parameter_3' )";
      if(mysqli_query($conn, $sql)){
         header('Location: index.php');
      }else{
         echo'error'. mysqli_error($conn);
      }
   }
}
mysqli_free_result($result);
mysqli_close($conn);
?>






<!DOCTYPE html>
<html lang="en" dir="ltr">
   <?php include('templates/header.php'); ?>

     <div class="nname">
         <h1 >Product Add</h1>
     </div>

<form method="POST" id ="myform2" name ="myform2" action="add.php">

   <div class="deleteb">
    <input type="submit" name="fsubmit" value="Save" >
   </div>

   <div class="adding">
      <div class="addInfo">

         <label class="addingLabel" id = "skuL">SKU:</label>
         <input type="text" name="sku" id = "sku" class="skuInput" value="<?php echo htmlspecialchars($sku)?>">
         <div class ='error'>
            <?php echo $errors['sku'] ?>
         </div>

         <br>
         <label class="addingLabel">Name:</label>
         <input type="text" name="name" value="<?php echo htmlspecialchars($name)?>">
         <div class ='error' >
            <?php echo $errors['name'] ?>
         </div>

         <br>
         <label class="addingLabel">Price:</label>
         <input type="text" name="price" value="<?php echo htmlspecialchars($price) ?>">
         <div class ='error' >
            <?php echo $errors['price'] ?>
         </div>

         <p>Type Switcher
            <select  name="selectProduct" id="selectProduct" class="typeSwitcher">
               <option value="" selected disabled>Select product</option>
               <option  <?php if($selected == 1){ ?>  selected = "selected"   <?php } ?>  value="1">DVD-disc</option>
               <option <?php if($selected == 2){ ?>  selected = "selected"   <?php } ?>  value="2">Furniture</option>
               <option <?php if($selected == 3){ ?>  selected = "selected"   <?php } ?>  value="3">Book</option>
            </select>
         </p>
         <div class ='errorType'>
            <?php echo $errors['type'] ?>
         </div>

         <div class="package" id ='1'>
            <?php include('items/disc.php'); ?>
         </div>
         <div class="package" id ='2'>
            <?php include('items/furniture.php'); ?>
         </div>
         <div class="package" id ='3'>
            <?php include('items/book.php'); ?>
         </div>

         <?php if ($selected == 1 ) { ?>
            <div class="package2">
               <?php include('items/disc.php'); ?>
            </div>
         <?php } elseif ($selected == 2 ) { ?>
            <div class="package2">
               <?php include('items/furniture.php'); ?>
            </div>
         <?php } elseif ($selected == 3 ) { ?>
            <div class="package2">
               <?php include('items/book.php'); ?>
            </div>
         <?php } ?>

      </div>
   </div>
</form>

<script>
   $("#selectProduct").change(function(){
   var displayProduct = $("#selectProduct option:selected").val();
   $(".package").css('display','none');
   $(".errorType").css('display','none');
   $(".package2").css('display','none');
   $("#" + displayProduct).css('display','block');
  });
</script>

<script>
  $("#skuL").click(function(){
  var skuPart1 = Math.floor(Math.random()*(999-100+1)+100);
  var skuPart2 = Math.floor(Math.random()*(999-100+1)+100);
  var displayProduct = $("#selectProduct option:selected").val();
    switch (displayProduct) {
      case '1':
         var sku = skuPart1.toString() + "CDC" + skuPart2.toString();
         $("#sku").val(sku);
      break;
      case '2':
         var sku = skuPart1.toString() + "FNF" + skuPart2.toString();
        $("#sku").val(sku);
      break;
      case '3':
         var sku = skuPart1.toString() + "BOB" + skuPart2.toString();
         $("#sku").val(sku);
      break;
      default:
    }
  });
</script>

   <?php include('templates/footer.php'); ?>
</html>
