<div class="bookForm" >

 <!-- product - books-->

<!-- input for books only parameter -->
   <br>
   <label class="addingLabel">Weight:</label>
   <input type="text" name="parameter[]" value="<?php echo htmlspecialchars($_POST['parameter'][4] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['bookWeight'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide weight of the book in "g".</li>
      <li>Weight  <?php echo $dimensionForm ?></li>
      <li><?php echo $skuForm ?></li>
      <li><?php echo $priceForm ?></li>
      <li>(SKU must contain "BOB" in order to get saved as Book)</li>
   </div>

</div>
