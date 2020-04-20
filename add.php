<?php

//variables - seen what is used later on
$sku = $name = $price = $dvdSize = $bookWeight = $parameter_1 = $parameter_2 = $parameter_3 ='';


// connection to database and convertation of sql table to variable - used to compare SKU and check whether
// there already is product with same SKU
include('config/db_connect.php');
$orderBy = 'created_at';
$sql = "SELECT * FROM things ORDER BY $orderBy";
$result = mysqli_query($conn, $sql);
$things = mysqli_fetch_all($result, MYSQLI_ASSOC);


// main class used to create products
class Product{
   public $data;
   public $error2 = [];
   private static $inputs = ['sku', 'name', 'price'];
   public $things;
   public $pattern = '/^(0|[1-9]\d*)(\.\d{1,2})?$/';
   public $pattern2 = '/^[0-9]*$/';

   public function __construct($post_data){
      $this->data = $post_data;
   }

// check whether there is such input
   public function checkInput(){
      foreach (self::$inputs as $input) {
         if(!array_key_exists($input, $this->data)){
            trigger_error("There is no $input");
            return;
         }
      }

// check of the input itself - whether it is in the right format (regular expression)
      $this->checkType();
      $this->checkSku();
      $this->checkName();
      $this->checkPrice();

      return $this->error2;
   }

// check if the type is selected
   public function checkType(){
      if(empty($this->data['selectProduct'])){
         $this->checkError('type', 'Type not selected');
      }
   }

// check of the sku - whether it is inputed and not same with already existing
   public function checkSku(){
      $temp = trim($this->data['sku']);
      if(empty($temp)){
         $this->checkError('sku', 'Sku is empty');
      }else {
         global $things;
// comparing to the already existing SKU
         foreach ($things as $thing) {
            if($thing['sku'] == $temp){
               $this->checkError('sku', 'SKU is already taken');
            }
         }
      }

   }

// check if the name is inputed
   public function checkName(){
   $temp = trim($this->data['name']);
      if(empty($temp)){
         $this->checkError('name', 'Name is empty');
      }else{

      }
   }

// check if the price is inputed and is in the right format
   public function checkPrice(){
      $temp = trim($this->data['price']);
      $pattern = $this->pattern;

      if(empty($temp)){
         $this->checkError('price', 'Price is empty');
      }else{

         if(preg_match($pattern,$temp) == '0'){
            $this->checkError('price', 'Wrong price format. Use integers and only 2 digits after "." <br/>
                                       (Use "." to separate dollars and cents.)');
         }else {
            $this->data['price'] = number_format($temp, 2, '.', '');
            $_POST['price'] = $this->data['price'];
         }
      }
   }

// function for error output. Errors are put into the linked array
   public function checkError($key, $reason){
      $this->error2[$key] = $reason;
   }
}

// extension of the main class for product - DVD
   class Dvd extends Product{


      public function __construct($post_data){
// getting common parameters(SKU,Name ,Price) from parent class
         parent::__construct($post_data);

// check of input - if it is present and format of it
         $temp = trim($this->data['dvdSize']);
         if(empty($temp)){
// function to write down error
            $this->checkError('dvdSize', 'Size is empty');
         }else{
            if(preg_match($this->pattern2,$temp) == '0'){
               $this->checkError('dvdSize', 'Wrong input of size' );
            }else {
               global $parameter_1;
               $parameter_1 = $temp;
            }
         }

// check of the sku - it should contain CDC
         $tempSku = trim($this->data['sku']);
         if(preg_match('/CDC/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain CDC');
         }
      }
   }

// extension of the main class for product - Furniture
   class Furniture extends Product{
      public function __construct($post_data){
// getting common parameters(SKU,Name ,Price) from parent class
         parent::__construct($post_data);

         $temp1= trim($this->data['parameter_1']);
         $temp2= trim($this->data['parameter_2']);
         $temp3= trim($this->data['parameter_3']);

// check of every of 3 parameters by order from first to last
         if(empty($temp1)){
            $this->checkError('parameter_1', 'parameter 1 is empty');
         }else{
            if(preg_match($this->pattern2,$temp1) == '0'){
               $this->checkError('parameter_1', 'Wrong input of parameter 1' );
            }else {
               global $parameter_1;
               $parameter_1  = $temp1;
            }
         }
         if(empty($temp2)){
            $this->checkError('parameter_2', 'parameter 2 is empty');
         }else{
            if(preg_match($this->pattern2,$temp2) == '0'){
               $this->checkError('parameter_2', 'Wrong input of parameter 2' );
            }else {
               global $parameter_2;
               $parameter_2 = $temp2;
            }
         }

         if(empty($temp3)){
            $this->checkError('parameter_3', 'parameter 3 is empty');
         }else{
            if(preg_match($this->pattern2,$temp3) == '0'){
               $this->checkError('parameter_3', 'Wrong input of parameter 3' );
            }else {
               global $parameter_3;
               $parameter_3 = $temp3;
            }
         }

// check of the sku - it should contain FNF
         $tempSku = trim($this->data['sku']);
         if(preg_match('/FNF/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain FNF');
         }
      }
   }

//extension of the main class for product - Book
   class Book extends Product{

      public function __construct($post_data){
// getting common parameters(SKU,Name ,Price) from parent class
         parent::__construct($post_data);

// check of the parameter
         $temp = trim($this->data['bookWeight']);
         if(empty($temp)){
            $this->checkError('bookWeight', 'Weight is empty');
         }else{
            if(preg_match($this->pattern2,$temp) == '0'){
               $this->checkError('bookWeight', 'Wrong input of weight' );
            }else {
               global $parameter_1;
               $parameter_1 = $temp;
            }
         }
// check of the sku - it should contain BOB
         $tempSku = trim($this->data['sku']);
         if(preg_match('/BOB/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain BOB');
         }
      }
   }

// if form is submitted - button "save" pressed
if(isset($_POST['fsubmit'])){
   $selctedFormat =( $_POST['selectProduct'] ?? '' );

// create class depending on selected products from drop down list
   switch ($selctedFormat) {
      case '1':
         $mainObject = new Dvd($_POST);
      break;

      case '2':
         $mainObject = new Furniture($_POST);
      break;

      case '3':
         $mainObject = new Book($_POST);
      break;

      default:
         $mainObject = new Product($_POST);
      break;
   }

// errors that were noticed after checking all inputs
   $errors = $mainObject->checkInput();

// in case array of errors is empty (no errors)
   if(array_filter($errors)){

   }else{

// declaration of variables for input into sql database
      $sku = mysqli_real_escape_string($conn, $mainObject->data['sku']);
      $name = mysqli_real_escape_string($conn, $mainObject->data['name']);
      $price = mysqli_real_escape_string($conn, $mainObject->data['price']);
      $type = mysqli_real_escape_string($conn, $selctedFormat);
      $parameter_1 = mysqli_real_escape_string($conn, $parameter_1);
      $parameter_2 = mysqli_real_escape_string($conn, $parameter_2);
      $parameter_3 = mysqli_real_escape_string($conn, $parameter_3);

// insertion into the database
      $sql = "INSERT INTO things(sku, name, price, type, parameter_1, parameter_2, parameter_3) VALUES('$sku', '$name', '$price', '$type', '$parameter_1', '$parameter_2', '$parameter_3' )";
      if(mysqli_query($conn, $sql)){
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
         <div class ='error'>
            <?php echo $errors['sku'] ?? '' ?>
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
               <?php $selctedFormat =( $_POST['selectProduct'] ?? '' );?>
<!-- selected type is shown after the form is submitted and there were errors (returned back to add.php)  (selected ="selected")              -->
               <option  <?php if($selctedFormat == 1){ ?>  selected = "selected"   <?php } ?>  value="1">DVD-disc</option>
               <option <?php if($selctedFormat == 2){ ?>  selected = "selected"   <?php } ?>  value="2">Furniture</option>
               <option <?php if($selctedFormat == 3){ ?>  selected = "selected"   <?php } ?>  value="3">Book</option>
            </select>
         </p>


<!-- link to every product description and input fields -->
         <div class ='errorType'>
            <?php echo $errors['type'] ?? ''  ?>
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

 <!-- link to every product description in order to change the output dynamically -->
         <?php if ($selctedFormat == 1 ) { ?>
            <div class="package2">
               <?php include('items/disc.php'); ?>
            </div>
         <?php } elseif ($selctedFormat == 2 ) { ?>
            <div class="package2">
               <?php include('items/furniture.php'); ?>
            </div>
         <?php } elseif ($selctedFormat == 3 ) { ?>
            <div class="package2">
               <?php include('items/book.php'); ?>
            </div>
         <?php } ?>


      </div>
   </div>
</form>


<script>
// script that shows a description of selected product without submitting the form (dynamically change)

   $("#selectProduct").change(function(){
      var displayProduct = $("#selectProduct option:selected").val();
      $(".package").css('display','none');
      $(".errorType").css('display','none');
      $(".package2").css('display','none');
      $("#" + displayProduct).css('display','block');
  });
</script>

<script>
//script for a random SKU generation that meets requirements for the selected product type

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

<script>
// script for right price format

   $("#priceL").click(function(){
      var displayProduct = $("#selectProduct option:selected").val();
      var priceFormat="0.00";
      if(!displayProduct==""){
         $("#price").val(priceFormat);
      }

   });
</script>

<!-- link with the footer -->
   <?php include('templates/footer.php'); ?>
</html>
