<?php

// same description of items
include('templates/description.php');

// connection to database and convertation of sql table to variable - used to compare SKU and check whether  there already is product with same SKU
include('config/db_connect.php');

// class used to create products (add them)
include('templates/common_class_add.php');

// selection from drop down menu
$selctedFormat = 0;
if (isset($_POST['selectProduct'])){
   $selctedFormat = $_POST['selectProduct'];
}

// if form is submitted - button "save" pressed
if(isset($_POST['fsubmit'])){

// create class depending on selected products from drop down list

   $mainObject = new Product($_POST);

   switch ($selctedFormat) {
      case '1':
         $skuPart = 'CDC';
         $parameter_1 = trim($mainObject->getParameter(0));
            checkParameter($mainObject, $parameter_1, 'dvdSize', 'size');
      break;

      case '2':
         $skuPart = 'FNF';
         $parameter_1 = trim($mainObject->getParameter(1));
            checkParameter($mainObject, $parameter_1, 'furnitureHeight', 'height');
         $parameter_2 = trim($mainObject->getParameter(2));
            checkParameter($mainObject, $parameter_2, 'furnitureWidth', 'width');
         $parameter_3 = trim($mainObject->getParameter(3));
            checkParameter($mainObject, $parameter_3, 'furnitureLenght', 'lenght');
      break;

      case '3':
         $skuPart = 'BOB';
         $parameter_1 = trim($mainObject->getParameter(4));
            checkParameter($mainObject, $parameter_1, 'bookWeight', 'weight');
      break;

      default:
         $skuPart='';
         $mainObject->setType(0);
      break;

   }
// chehk of all parameters (sku, name, price)
   checkAll($mainObject,$skuPart,$things);

// errors that were noticed after checking all inputs
   $errors = $mainObject->getErrors();

// in case array of errors is empty (no errors)
   if(!array_filter($errors)){
// declaration of variables for input into sql database
      $sku = mysqli_real_escape_string($conn, $mainObject->getSku());
      $name = mysqli_real_escape_string($conn, $mainObject->getName());
      $price = mysqli_real_escape_string($conn, $mainObject->getPrice());
      $type = mysqli_real_escape_string($conn, $mainObject->getType());
      $parameter_1 = mysqli_real_escape_string($conn, $parameter_1);
      $parameter_2 = mysqli_real_escape_string($conn, $parameter_2);
      $parameter_3 = mysqli_real_escape_string($conn, $parameter_3);
// insertion into the database
      $sql = "INSERT INTO things(sku, name, price, type, parameter_1, parameter_2, parameter_3) VALUES('$sku', '$name', '$price', '$type', '$parameter_1', '$parameter_2', '$parameter_3' )";
      if(mysqli_query($conn, $sql)){
// redirecting to main page
         header('Location: index.php');
      }else{
         echo'error'. mysqli_error($conn);
      }
   }
}

// closing connection with the database
mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<!-- link with the header -->
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

<!-- 3 common parameters - valid for every product  -->
         <label class="addingLabel" id = "skuL">SKU:</label>
<!-- in case something was inputed before and there were errors in form - input is shown after save button is pressed -->
         <input type="text" name="sku" id = "sku" class="skuInput" value="<?php echo htmlspecialchars($_POST['sku'] ?? '' )?>">
<!-- showing error message for this parameter -->
         <div class ='error' >
            <div id ='skuError' >
               <?php echo $errors['sku'] ?? '' ?>
            </div>
         </div>

         <br>
         <label class="addingLabel">Name:</label>
         <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '' )?>">
         <div class ='error' >
            <?php echo $errors['name'] ?? '' ?>
         </div>

         <br>
         <label class="addingLabel" id = "priceL">Price:</label>
         <input type="text" name="price" id="price" value="<?php echo htmlspecialchars( $_POST['price'] ?? '');?>">

         <div class ='error' >
            <?php echo $errors['price'] ?? '' ?>
         </div>


<!-- selection of product type -->
         <p>Type Switcher
            <select  name="selectProduct" id="selectProduct" class="typeSwitcher">
               <option value="" selected disabled>Select product</option>

               <?php ?>

<!-- selected type is shown after the form is submitted and there were errors (returned back to add.php)  (selected ="selected") -->
               <option  <?php if($selctedFormat == 1){ ?>  selected = "selected"   <?php } ?>  value="1">DVD-disc</option>
               <option <?php if($selctedFormat == 2){ ?>  selected = "selected"   <?php } ?>  value="2">Furniture</option>
               <option <?php if($selctedFormat == 3){ ?>  selected = "selected"   <?php } ?>  value="3">Book</option>
            </select>
         </p>
         <div class ='errorType'>
            <?php echo $errors['type'] ?? ''  ?>
         </div>


<!-- link to every product description and input fields -->
         <div class="package" id ='1'>
            <?php include('items/disc.php'); ?>
         </div>
         <div class="package" id ='2'>
            <?php include('items/furniture.php'); ?>
         </div>
         <div class="package" id ='3'>
            <?php include('items/book.php'); ?>
         </div>

      </div>
   </div>
</form>


<?php include('templates/functions.php'); ?>

<!-- link with the footer -->
   <?php include('templates/footer.php'); ?>
</html>
