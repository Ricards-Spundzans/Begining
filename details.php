<?php

include('config/db_connect.php');

class productDisplay {
   public $id;
   public $sku;
   public $name;
   public $price;
   public $type;
   public $created_at;
   public $parameterAll;

   public function __construct($thing){
      $this->id = $thing['id'];
      $this->sku = $thing['sku'];
      $this->name = $thing['name'];
      $this->price = $thing['price'];
      $this->created_at = $thing['created_at'];

      switch ($thing['type']) {
         case '1':
            $this->type = 'CD';
            $this->parameterAll = 'Size: ' . $thing['parameter_1'] . ' MB';
         break;

         case '2':
            $this->type = 'Furniture';
            $this->parameterAll = 'Dimension: ' . $thing['parameter_1'] . ' x ' . $thing['parameter_2'] . ' x ' . $thing['parameter_3'] . 'mm';
         break;

         case '3':
            $this->type = 'Book';
            $this->parameterAll = 'Weight: ' . $thing['parameter_1'] . ' g';
         break;

         default:
            echo 'error';
         break;
      }
   }

}

if (isset($_POST['delete'])) {

   $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
   $sql = "DELETE FROM things WHERE id = $id_to_delete";

   if (mysqli_query($conn, $sql)) {
      header('Location: index.php');
   }else{
      echo 'error';
   }
}


if (isset($_GET['id'])) {
   $id = mysqli_real_escape_string($conn, $_GET['id']);
   //make sql
   $sql = "SELECT * FROM things WHERE id = $id";
   //geting result
   $result = mysqli_query($conn, $sql);
   //result to array
   $thing = mysqli_fetch_assoc($result);

   $selectedProduct = new productDisplay($thing);
   //closing
   mysqli_free_result($result);
   mysqli_close($conn);
}


 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">

<?php include('templates/header.php'); ?>

<div class="nname">
   <h1>Details</h1>
</div>

<div class="detailBox">

   <div class="detailsAll">
      <?php if($thing): ?>

         <h3>Id: <?php echo htmlspecialchars($selectedProduct->id) ?></h3>
         <p>SKU: <?php echo htmlspecialchars($selectedProduct->sku) ?></p>
         <p>Name: <?php echo htmlspecialchars($selectedProduct->name) ?></p>
         <p>Price: <?php echo htmlspecialchars($selectedProduct->price)." $" ?></p>
         <p>Type: <?php echo htmlspecialchars($selectedProduct->type) ?></p>
         <p><?php echo htmlspecialchars($selectedProduct->parameterAll) ?></p>
         <p>Created at: <?php echo date($selectedProduct->created_at) ?></p>

         <!-- delete -->
         <div class="deleteDetail">
           <form class="" action="details.php" method="POST">
              <input type="hidden" name="id_to_delete" value="<?php echo "$selectedProduct->id" ?>">
              <input type="submit" name="delete" value="Delete" class = "btn">
           </form>
         </div>
         <br>

      <?php else: ?>
         <h5>There is nothing with this ID...</h5>
      <?php endif; ?>

   </div>
</div>
<?php include('templates/footer.php'); ?>

</html>
