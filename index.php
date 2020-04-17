<?php

include('config/db_connect.php');

$error = $selectedOption = '';
$orderBy = 'created_at';

$sql = "SELECT * FROM things ORDER BY $orderBy";
$result = mysqli_query($conn, $sql);
$things = mysqli_fetch_all($result, MYSQLI_ASSOC);


class productDisplay {
   public $id;
   public $sku;
   public $name;
   public $price;
   public $type;

   public $parameterAll;

   public function __construct($thing){
      $this->id = $thing['id'];
      $this->sku = $thing['sku'];
      $this->name = $thing['name'];
      $this->price = $thing['price'];

      switch ($thing['type']) {
         case '1':
            $this->parameterAll = $thing['parameter_1'] . ' MB';
         break;

         case '2':
            $this->parameterAll =  $thing['parameter_1'] . ' x ' . $thing['parameter_2'] . ' x ' . $thing['parameter_3'] . 'mm';
         break;

         case '3':
            $this->parameterAll =  $thing['parameter_1'] . ' g';
         break;

         default:
            echo 'error';
         break;
      }
   }

}


if(isset($_POST['apply'])){
  if(empty($_POST['optionSelect'])){
      $error = 'Please choose option <br />';
  }else {
      $selectedOption = $_POST['optionSelect'];
      switch ($selectedOption) {

      case 'massDelete':
         if(!empty($_POST['chose'])){
            foreach ($_POST['chose'] as $chosen) {
               $id_to_delete = mysqli_real_escape_string($conn, $chosen);
               $sql = "DELETE FROM things WHERE id = $id_to_delete";
               if (mysqli_query($conn, $sql)) {
                  header('Location: index.php');
               }else{
                  echo 'error';
               }
            }
         } else{
            $error = 'Nothing is chosen';
         }
      break;

      case 'id':
         $orderBy = 'id';
      break;

      case 'sku':
         $orderBy = 'sku';
      break;

      case 'name':
         $orderBy = 'name';
      break;

      case 'type':
         $orderBy = 'type';
      break;

      case 'price':
         $orderBy = 'price';
      break;
      case 'created_at':
         $orderBy = 'created_at';
      break;

      default:
         $error = 'UnexpectedValueException';
      break;
     }
     if ($selectedOption != 'massDelete') {
       $sql = "SELECT * FROM things ORDER BY $orderBy";
       $result = mysqli_query($conn, $sql);
       $things = mysqli_fetch_all($result, MYSQLI_ASSOC);
       $error ='';
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
      <h1 >Product list</h1>
</div>

<form class="" method="post">

   <div class="deleteb">
      <select class="optionSelect" name="optionSelect" id="optionSelect">
         <option value="" selected disabled>Sort/Delete</option>
         <option <?php if($selectedOption == 'id'){ ?>  selected = "selected" <?php } ?> value="id">Sort by ID</option>
         <option <?php if($selectedOption == 'sku'){ ?>  selected = "selected" <?php } ?> value="sku">Sort by SKU</option>
         <option <?php if($selectedOption == 'name'){ ?>  selected = "selected" <?php } ?> value="name">Sort by Name</option>
         <option <?php if($selectedOption == 'type'){ ?>  selected = "selected" <?php } ?> value="type">Sort by Type</option>
         <option <?php if($selectedOption == 'price'){ ?>  selected = "selected" <?php } ?> value="price">Sort by Price</option>
         <option <?php if($selectedOption == 'created_at'){ ?>  selected = "selected" <?php } ?> value="created_at">Sort by Created at</option>
         <option <?php if($selectedOption == 'massDelete'){ ?>  selected = "selected" <?php } ?> value="massDelete">Delete chosen</option>
      </select>
      <input type="submit" name="apply" value="Apply">
      <p class ='error'><?php echo $error ?> </p>
   </div>

   <div class="containers">

      <div class='wrap' >
         <?php foreach ($things as $thing): ?>
            <?php $onedProduct = new productDisplay($thing)?>
            <div>

               <div class = 'checkboxb'>
                  <input type="checkbox" name="chose[]" value="<?php echo htmlspecialchars($onedProduct->id)?>">
               </div>

               <div class="infoC">

                  <li><?php echo htmlspecialchars($onedProduct->sku) ?></li>
                  <li><?php echo htmlspecialchars($onedProduct->name) ?></li>
                  <li><?php echo htmlspecialchars($onedProduct->price)." $" ?></li>
                  <li><?php echo htmlspecialchars($onedProduct->parameterAll) ?></li>

               </div>

               <div class ='detailb' >
                  <a href="details.php?id=<?php echo htmlspecialchars($onedProduct->id) ?>">more info</a>
               </div>

            </div>
         <?php endforeach; ?>
      </div>
   </div>
</form>

   <?php include('templates/footer.php'); ?>
</html>
