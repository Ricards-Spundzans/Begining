<?php

// connecting to the database
include('config/db_connect.php');

// common class to show products
include('templates/common_class_show.php');

// individual delete option
if (isset($_POST['delete'])) {
   $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);
   $sql = "DELETE FROM things WHERE id = $id_to_delete";
   if (mysqli_query($conn, $sql)) {
      header('Location: index.php');
   }else{
      echo 'error';
   }
}

// showing only one, selected product from the catalogue
if (isset($_GET['id'])) {
   $id = mysqli_real_escape_string($conn, $_GET['id']);
//make sql where chosen is one specific ID
   $sql = "SELECT * FROM things WHERE id = $id";
//geting result form the sql
   $result = mysqli_query($conn, $sql);
//result to the array
   $thing = mysqli_fetch_assoc($result);

   if($thing){
      $selectedProduct = new productDisplay($thing);
   }

//closing the sql
   mysqli_free_result($result);
   mysqli_close($conn);
}

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">

<!-- link with the header -->
<?php include('templates/header.php'); ?>

<div class="nname">
   <h1>Details</h1>
</div>

<div class="detailBox">

   <div class="detailsAll">
      <?php if($thing): ?>
         <?php setProperties($selectedProduct,$thing) ?>
<!-- details shown to user -->
         <h3>Id: <?php echo htmlspecialchars($selectedProduct->getId()) ?></h3>
         <p>SKU: <?php echo htmlspecialchars($selectedProduct->getSku()) ?></p>
         <p>Name: <?php echo htmlspecialchars($selectedProduct->getName()) ?></p>
         <p>Price: <?php echo htmlspecialchars($selectedProduct->getPrice())." $" ?></p>
         <p>Type: <?php echo htmlspecialchars($selectedProduct->getTypeName()) ?></p>
         <p><?php echo htmlspecialchars($selectedProduct->getDimension().": ". $selectedProduct->getParameter()) ?></p>
         <p>Created at: <?php echo date($selectedProduct->getCreatedAt()) ?></p>

<!-- delete option for one product -->
         <div class="deleteDetail">
           <form class="" action="details.php" method="POST">
              <input type="hidden" name="id_to_delete" value="<?php echo $selectedProduct->getId() ?>">
              <input type="submit" name="delete" value="Delete" class = "btn">
           </form>
         </div>
         <br>

      <?php else: ?>
<!-- case if wrong ID input   -->
         <h5>There is nothing with this ID...</h5>
      <?php endif; ?>

   </div>
</div>

<!-- link with the footer -->
   <?php include('templates/footer.php'); ?>

</html>
