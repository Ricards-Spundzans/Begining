<?php

// conecting to the database
include('config/db_connect.php');

// getting data from the database - converting to the variable

$error = $selectedOption = '';
include('templates/common_class_show.php');


// if button "apply" is pressed
if(isset($_POST['apply'])){
// case if nothing is chosen
  if(empty($_POST['optionSelect'])){
      $error = 'Please choose option <br />';
  }else {
      $selectedOption = $_POST['optionSelect'];

      switch ($selectedOption) {
      case 'massDelete':
// delete function - deleting products with checked checkboxes
         if(!empty($_POST['chose'])){
            foreach ($_POST['chose'] as $chosen) {
// each of chosen products are deleted
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
      default:
// all other options are sorting options - products get sorted by chosen parameter
         $orderBy = $selectedOption;
      break;

     }

     if ($selectedOption != 'massDelete') {
// showing products in selected order (SKU, Price, Name, ID, Type, Created_at)
       $sql = "SELECT * FROM things ORDER BY $orderBy";
       $result = mysqli_query($conn, $sql);
       $things = mysqli_fetch_all($result, MYSQLI_ASSOC);
       $error ='';
     }

   }
}

// disconeting form the sql database
mysqli_free_result($result);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- link with the header -->
   <?php include('templates/header.php'); ?>

<div class="nname">
      <h1 >Product list</h1>
</div>

<form class="" method="post">

   <div class="deleteb">

<!-- selection of sorting or deleting       -->
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
<!-- each product in database is separated as individual product             -->
            <?php $oneProduct = new productDisplay($thing)?>
            <?php setProperties($oneProduct,$thing) ?>
            <div>

               <div class = 'checkboxb'>
                  <input class = "checkbox__input" id="checkbox__input" onclick="isChecked(this)" type="checkbox" name="chose[]" value="<?php echo htmlspecialchars($oneProduct->getId())?>">
               </div>

               <div class="infoC">
 <!-- information about one thing -->
                  <li><?php echo htmlspecialchars($oneProduct->getSku()) ?></li>
                  <li><?php echo htmlspecialchars($oneProduct->getName()) ?></li>
                  <li><?php echo htmlspecialchars($oneProduct->getPrice())." $" ?></li>
                  <li><?php echo htmlspecialchars($oneProduct->getParameter()) ?></li>

               </div>
 <!-- link to the detail page -->
               <div class ='detailb' >
                  <a href="details.php?id=<?php echo htmlspecialchars($oneProduct->getId()) ?>">more info</a>
               </div>

            </div>
         <?php endforeach; ?>
      </div>
   </div>
</form>

<!-- link with the footer -->
   <?php include('templates/footer.php'); ?>

</html>
