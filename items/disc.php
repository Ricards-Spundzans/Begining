<div class="discForm" >


   <!-- product - disc-->


<!-- input for CD only parameter -->
   <br>
   <label class="addingLabel">Size:</label>
   <input type="text" name="parameter[]" value="<?php echo htmlspecialchars($_POST['parameter'][0] ?? '' )?>">

   <div class ='error' >
      <?php echo $errors['dvdSize'] ?? '' ?>
   </div>
   <br>

<!-- short help for user with details about input -->
   <div class="chooseHelp">
      <li>Please provide size of DVD-disc in "MB".</li>
      <li>Size <?php echo $dimensionForm ?></li>
      <li><?php echo $skuForm ?></li>
      <li><?php echo $priceForm ?></li>
      <li>(SKU must contain "CDC" in order to get saved as DVD) </li>
   </div>

</div>
