<?php

include('config/db_connect.php');

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

         <h3>Id: <?php echo htmlspecialchars($thing['id']) ?></h3>
         <p>SKU: <?php echo htmlspecialchars($thing['sku']) ?></p>
         <p>Name: <?php echo htmlspecialchars($thing['name']) ?></p>
         <p>Price: <?php echo htmlspecialchars($thing['price'])." $" ?></p>

         <p>Type: <?php if($thing['type'] == 1){ echo "CD";}
            elseif($thing['type'] == 2) { echo "Furniture";  }
            elseif($thing['type'] == 3) { echo "Book";  }
            else{echo "ERROR - no type";} ?>
         </p>

         <?php if($thing['type'] == 1): ?>
            <p>Size: <?php echo htmlspecialchars($thing['parameter_1']). ' MB' ?></p>
         <?php elseif($thing['type'] == 2): ?>
            <p>Dimension:  <?php echo htmlspecialchars($thing['parameter_1'] . ' x ' . $thing['parameter_2']. ' x ' . $thing['parameter_3'] . ' mm'  )  ?></p>
         <?php elseif($thing['type'] == 3): ?>
            <p>Weight:  <?php echo htmlspecialchars($thing['parameter_1']). ' g'   ?></p>
         <?php endif; ?>

         <p>Created at: <?php echo date($thing['created_at']) ?></p>

         <!-- delete -->
         <div class="deleteDetail">
           <form class="" action="details.php" method="POST">
              <input type="hidden" name="id_to_delete" value="<?php echo $thing['id'] ?>">
              <input type="submit" name="delete" value="Delete" class = "btn">
           </form>
         </div>


      <?php else: ?>
         <h5>There is nothing with this ID...</h5>
      <?php endif; ?>

   </div>
</div>
<?php include('templates/footer.php'); ?>

</html>
