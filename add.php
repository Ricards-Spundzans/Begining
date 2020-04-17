<?php

$sku = $name = $price = $dvdSize = $bookWeight = $parameter_1 = $parameter_2 = $parameter_3 ='';


include('config/db_connect.php');
$orderBy = 'created_at';
$sql = "SELECT * FROM things ORDER BY $orderBy";
$result = mysqli_query($conn, $sql);
$things = mysqli_fetch_all($result, MYSQLI_ASSOC);


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

   public function checkInput(){
      foreach (self::$inputs as $input) {
         if(!array_key_exists($input, $this->data)){
            trigger_error("There is no $input");
            return;
         }
      }

      $this->checkType();
      $this->checkSku();
      $this->checkName();
      $this->checkPrice();

      return $this->error2;
   }

   public function checkType(){
      if(empty($this->data['selectProduct'])){
         $this->checkError('type', 'Type not selected');
      }
   }


   public function checkSku(){
      $temp = trim($this->data['sku']);

      if(empty($temp)){
         $this->checkError('sku', 'Sku is empty');
      }else {
         global $things;
         foreach ($things as $thing) {
            if($thing['sku'] == $temp){
               $this->checkError('sku', 'SKU is already taken');
            }
         }
      }

   }

   public function checkName(){
   $temp = trim($this->data['name']);
      if(empty($temp)){
         $this->checkError('name', 'Name is empty');
      }else{

      }
   }

   public function checkPrice(){

      $temp = trim($this->data['price']);
      $pattern = $this->pattern;

      if(empty($temp)){
         $this->checkError('price', 'Price is empty');
      }else{

         if(preg_match($pattern,$temp) == '0'){
            $this->checkError('price', 'Wrong price format. Use integers and only 2 digits after "." <br/> (Please use "." between dollars and cents.)');
         }else {
            $this->data['price'] = number_format($temp, 2, '.', '');
            $_POST['price'] = $this->data['price'];
         }
      }
   }

   public function checkError($key, $reason){
      $this->error2[$key] = $reason;
   }
}
   class Dvd extends Product{

      public function __construct($post_data){
         parent::__construct($post_data);

         $temp = trim($this->data['dvdSize']);
         if(empty($temp)){
            $this->checkError('dvdSize', 'Size is empty');
         }else{
            if(preg_match($this->pattern2,$temp) == '0'){
               $this->checkError('dvdSize', 'Wrong input of size' );
            }else {
               global $parameter_1;
               $parameter_1 = $temp;
            }
         }

         $tempSku = trim($this->data['sku']);
         if(preg_match('/CDC/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain CDC');
         }
      }
   }

   class Furniture extends Product{
      public function __construct($post_data){
         parent::__construct($post_data);

         $temp1= trim($this->data['parametr_1']);
         $temp2= trim($this->data['parametr_2']);
         $temp3= trim($this->data['parametr_3']);

         if(empty($temp1)){
            $this->checkError('parametr_1', 'Parametr 1 is empty');
         }else{
            if(preg_match($this->pattern2,$temp1) == '0'){
               $this->checkError('parametr_1', 'Wrong input of parametr 1' );
            }else {
               global $parameter_1;
               $parameter_1  = $temp1;
            }
         }
         if(empty($temp2)){
            $this->checkError('parametr_2', 'Parametr 2 is empty');
         }else{
            if(preg_match($this->pattern2,$temp2) == '0'){
               $this->checkError('parametr_2', 'Wrong input of parametr 2' );
            }else {
               global $parameter_2;
               $parameter_2 = $temp2;
            }
         }

         if(empty($temp3)){
            $this->checkError('parametr_3', 'Parametr 3 is empty');
         }else{
            if(preg_match($this->pattern2,$temp3) == '0'){
               $this->checkError('parametr_3', 'Wrong input of parametr 3' );
            }else {
               global $parameter_3;
               $parameter_3 = $temp3;
            }
         }
         $tempSku = trim($this->data['sku']);
         if(preg_match('/FNF/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain FNF');
         }
      }
   }

   class Book extends Product{

      public function __construct($post_data){
         parent::__construct($post_data);

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
         $tempSku = trim($this->data['sku']);
         if(preg_match('/BOB/',$tempSku) == '0' ){
            $this->checkError('sku', 'SKU doesnt contain BOB');
         }
      }
   }

if(isset($_POST['fsubmit'])){
$selctedFormat =( $_POST['selectProduct'] ?? '' );

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
   $errors = $mainObject->checkInput();

   if(array_filter($errors)){

   }else{

      $sku = mysqli_real_escape_string($conn, $mainObject->data['sku']);
      $name = mysqli_real_escape_string($conn, $mainObject->data['name']);
      $price = mysqli_real_escape_string($conn, $mainObject->data['price']);
      $type = mysqli_real_escape_string($conn, $selctedFormat);
      $parameter_1 = mysqli_real_escape_string($conn, $parameter_1);
      $parameter_2 = mysqli_real_escape_string($conn, $parameter_2);
      $parameter_3 = mysqli_real_escape_string($conn, $parameter_3);

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
         <label class="addingLabel">Price:</label>
         <input type="text" name="price" value="<?php echo htmlspecialchars( $_POST['price'] ?? '');?>">

         <div class ='error' >
            <?php echo $errors['price'] ?? '' ?>
         </div>


         <p>Type Switcher
            <select  name="selectProduct" id="selectProduct" class="typeSwitcher">
               <option value="" selected disabled>Select product</option>
               <?php $selctedFormat =( $_POST['selectProduct'] ?? '' );?>
               <option  <?php if($selctedFormat == 1){ ?>  selected = "selected"   <?php } ?>  value="1">DVD-disc</option>
               <option <?php if($selctedFormat == 2){ ?>  selected = "selected"   <?php } ?>  value="2">Furniture</option>
               <option <?php if($selctedFormat == 3){ ?>  selected = "selected"   <?php } ?>  value="3">Book</option>
            </select>
         </p>


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
